<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // 🔹 List all products
    public function index(Request $request)
    {
        $categories = Category::all();
        $brands = Brand::all();

        $products = Product::with(['category', 'subCategory', 'subSubCategory', 'brand', 'attribute']);

        if ($request->filled('search')) {
            $products->where('product_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $products->where('category_id', (int) $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $products->where('brand_id', (int) $request->brand_id);
        }

        if (!is_null($request->status) && $request->status !== '') {
            $products->where('status', (int) $request->status);
        }

        $products = $products->latest()->paginate(10)->withQueryString();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    // 🔹 Show create form
    public function create()
{
    $categories = Category::all();
    $brands = Brand::all();
    $attributes = Attribute::all();

    
    $subCategories = SubCategory::all();
    $subSubCategories = SubSubCategory::all();

    return view('admin.products.create', compact(
        'categories',
        'brands',
        'attributes',
        'subCategories',
        'subSubCategories'
    ));
}

    // 🔹 Store new product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'nullable|unique:products,sku',
            'unit_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'product_unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'additional_image.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        // Single image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Multiple images
        if ($request->hasFile('additional_image')) {
            $images = [];
            foreach ($request->file('additional_image') as $img) {
                $images[] = $img->store('products', 'public');
            }
            $data['additional_image'] = json_encode($images);
        }

        // Tags as array (store cleanly)
        if ($request->filled('tags')) {
            $tagsInput = $request->input('tags');
            $tagsArray = is_array($tagsInput)
                ? $tagsInput
                : array_filter(array_map('trim', explode(',', $tagsInput)));
            $data['tags'] = array_values($tagsArray);
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product Created Successfully');
    }

    // 🔹 Show single product
    public function show($id)
    {
        $product = Product::with(['category', 'subCategory', 'subSubCategory', 'brand', 'attribute'])
                          ->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // 🔹 Edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $attributes = Attribute::all();

        // Load all; filtering is handled client-side to preserve selection and allow switching
        $subCategories = SubCategory::all();
        $subSubCategories = SubSubCategory::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'attributes', 'subCategories', 'subSubCategories'));
    }

    // 🔹 Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'nullable|unique:products,sku,' . $id,
            'unit_price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'product_unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
            'additional_image.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $data = $request->all();

        // Update single image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Update multiple images
        // existing additional images
        $existingAdditional = is_array($product->additional_image)
            ? $product->additional_image
            : (json_decode($product->additional_image, true) ?: []);

        // remove selected additional images
        $remove = $request->input('remove_additional', []);
        if (!empty($remove)) {
            foreach ($remove as $path) {
                if (in_array($path, $existingAdditional, true)) {
                    Storage::disk('public')->delete($path);
                }
            }
            $existingAdditional = array_values(array_diff($existingAdditional, $remove));
        }

        // append newly uploaded additional images
        if ($request->hasFile('additional_image')) {
            foreach ($request->file('additional_image') as $img) {
                $existingAdditional[] = $img->store('products', 'public');
            }
        }
        $data['additional_image'] = $existingAdditional;

        // Tags as array (store cleanly)
        if ($request->filled('tags')) {
            $tagsInput = $request->input('tags');
            $tagsArray = is_array($tagsInput)
                ? $tagsInput
                : array_filter(array_map('trim', explode(',', $tagsInput)));
            $data['tags'] = array_values($tagsArray);
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }

    // 🔹 Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Optional: delete images from storage
        // if($product->image) Storage::disk('public')->delete($product->image);
        // if($product->additional_image) {
        //     foreach(json_decode($product->additional_image) as $img) {
        //         Storage::disk('public')->delete($img);
        //     }
        // }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product Deleted Successfully');
    }

    // Toggle status
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->status = !$product->status;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product status updated.');
    }

    // Show bulk import form
    public function importForm()
    {
        return view('admin.products.import');
    }

    // Download sample format for bulk import (CSV)
    public function importTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products_import_template.csv"',
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');

            // Header row
            fputcsv($out, [
                'product_name',
                'sku',
                'description',
                'unit_price',
                'stock_quantity',
                'category_id',
                'sub_category_id',
                'sub_sub_category_id',
                'brand_id',
                'product_type',
                'discount',
                'discount_type',
                'product_unit',
                'shipping_cost',
                'tax_amount',
                'attribute_id',
                'attribute_value',
                'tags',
                'status',
            ]);

            // Example row to guide users
            fputcsv($out, [
                'Sample Product',
                'SKU-001',
                'Short description here',
                '499.99',
                '100',
                '', // category_id
                '', // sub_category_id
                '', // sub_sub_category_id
                '', // brand_id
                'physical',
                '10',
                'percent',
                '50',
                '20',
                'piece',
                '', // attribute_id
                'Size: M',
                'home,decor',
                '1',
            ]);

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk import products from an uploaded Excel/CSV file.
     * Expected heading row (case-insensitive):
     * product_name, sku, description, unit_price, stock_quantity, category_id, sub_category_id,
     * sub_sub_category_id, brand_id, product_type, discount, discount_type, product_unit, shipping_cost,
     * tax_amount, attribute_id, attribute_value, tags, status
     */
    public function bulkImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt|max:2048',
        ]);

        $extension = strtolower($request->file('file')->getClientOriginalExtension());
        $tempPath  = $request->file('file')->getRealPath();

        $rows = $extension === 'csv'
            ? $this->readCsv($tempPath)
            : $this->readXlsx($tempPath);

        if (empty($rows) || count($rows) < 2) {
            return back()->withErrors(['file' => 'File is empty or could not be read.']);
        }

        $headerRaw = array_shift($rows);
        $header = array_map(fn ($h) => strtolower(trim($h)), $headerRaw);

        $required = ['product_name', 'unit_price', 'stock_quantity'];
        foreach ($required as $col) {
            if (!in_array($col, $header, true)) {
                return back()->withErrors([
                    'file' => "Missing required column: {$col}. Make sure your first row has headings.",
                ]);
            }
        }

        $imported = 0;
        $failed   = [];

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                $rowAssoc = [];
                foreach ($header as $i => $colName) {
                    $rowAssoc[$colName] = $row[$i] ?? null;
                }

                if (empty($rowAssoc['product_name'])) {
                    continue; // skip blank lines
                }

                try {
                    Product::create([
                        'product_name'        => $rowAssoc['product_name'],
                        'description'         => $rowAssoc['description'] ?? null,
                        'category_id'         => $this->intOrNull($rowAssoc['category_id'] ?? null),
                        'sub_category_id'     => $this->intOrNull($rowAssoc['sub_category_id'] ?? null),
                        'sub_sub_category_id' => $this->intOrNull($rowAssoc['sub_sub_category_id'] ?? null),
                        'brand_id'            => $this->intOrNull($rowAssoc['brand_id'] ?? null),
                        'product_type'        => $this->normalizeProductType($rowAssoc['product_type'] ?? null),
                        'sku'                 => $rowAssoc['sku'] ?: null,
                        'unit_price'          => $this->floatOrNull($rowAssoc['unit_price']) ?? 0,
                        'stock_quantity'      => $this->intOrNull($rowAssoc['stock_quantity']) ?? 0,
                        'discount'            => $this->floatOrNull($rowAssoc['discount']),
                        'discount_type'       => $this->normalizeDiscountType($rowAssoc['discount_type'] ?? null),
                        'product_unit'        => $rowAssoc['product_unit'] ?? null,
                        'shipping_cost'       => $this->floatOrNull($rowAssoc['shipping_cost']),
                        'tax_amount'          => $this->floatOrNull($rowAssoc['tax_amount']),
                        'attribute_id'        => $this->intOrNull($rowAssoc['attribute_id'] ?? null),
                        'attribute_value'     => $rowAssoc['attribute_value'] ?? null,
                        'tags'                => $this->splitTags($rowAssoc['tags'] ?? null),
                        'status'              => $rowAssoc['status'] === null ? 1 : (int) $rowAssoc['status'],
                    ]);
                    $imported++;
                } catch (\Throwable $e) {
                    $failed[] = 'Row ' . ($index + 2) . ': ' . $e->getMessage();
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Import failed: ' . $e->getMessage()]);
        }

        $message = "Imported {$imported} products.";
        if (!empty($failed)) {
            $message .= ' Some rows were skipped.';
        }

        return back()->with('success', $message)->with('import_failed_rows', $failed);
    }

    private function splitTags(?string $value): ?array
    {
        if (!$value) {
            return null;
        }
        $parts = array_filter(array_map('trim', explode(',', $value)));
        return empty($parts) ? null : array_values($parts);
    }

    private function readCsv(string $path): array
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                $rows[] = array_map('trim', $data);
            }
            fclose($handle);
        }
        return $rows;
    }

    /**
     * Minimal XLSX reader (first sheet only) to avoid extra packages.
     */
    private function readXlsx(string $path): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            return [];
        }

        $sharedStrings = [];
        if (($index = $zip->locateName('xl/sharedStrings.xml')) !== false) {
            $xml = simplexml_load_string($zip->getFromIndex($index));
            foreach ($xml->si as $item) {
                if (isset($item->t)) {
                    $sharedStrings[] = (string) $item->t;
                } elseif (isset($item->r)) {
                    $text = '';
                    foreach ($item->r as $r) {
                        $text .= (string) $r->t;
                    }
                    $sharedStrings[] = $text;
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXml) {
            $zip->close();
            return [];
        }

        $sheet   = simplexml_load_string($sheetXml);
        $rows    = [];

        foreach ($sheet->sheetData->row as $row) {
            $current = [];
            foreach ($row->c as $c) {
                $ref      = (string) $c['r']; // e.g. A1
                $colIndex = $this->columnToIndex(preg_replace('/[0-9]/', '', $ref));
                $value    = $this->extractCellValue($c, $sharedStrings);
                $current[$colIndex] = trim((string) $value);
            }
            if (!empty($current)) {
                ksort($current);
                $rows[] = array_values($current);
            }
        }

        $zip->close();
        return $rows;
    }

    private function extractCellValue(\SimpleXMLElement $cell, array $sharedStrings): string
    {
        $type = (string) $cell['t'];

        if ($type === 's') {
            $index = (int) $cell->v;
            return $sharedStrings[$index] ?? '';
        }

        if ($type === 'inlineStr' && isset($cell->is->t)) {
            return (string) $cell->is->t;
        }

        return isset($cell->v) ? (string) $cell->v : '';
    }

    private function columnToIndex(string $column): int
    {
        $column = strtoupper($column);
        $length = strlen($column);
        $index  = 0;

        for ($i = 0; $i < $length; $i++) {
            $index *= 26;
            $index += ord($column[$i]) - ord('A') + 1;
        }

        return $index - 1; // zero-based
    }

    private function intOrNull($value): ?int
    {
        return is_numeric($value) ? (int) $value : null;
    }

    private function floatOrNull($value): ?float
    {
        return is_numeric($value) ? (float) $value : null;
    }

    private function normalizeProductType($value): string
    {
        $value = strtolower((string) $value);
        return in_array($value, ['physical', 'digital'], true) ? $value : 'physical';
    }

    private function normalizeDiscountType($value): ?string
    {
        if (!$value) {
            return null;
        }
        $value = strtolower((string) $value);
        return in_array($value, ['flat', 'percent'], true) ? $value : null;
    }
}
