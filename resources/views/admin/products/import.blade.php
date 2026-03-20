@extends('layout.app')
@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-700 flex items-center space-x-2">
                <i class="fas fa-file-import text-purple-500 text-sm"></i><span>Bulk Product Import</span>
            </h3>
            <p class="text-[10px] text-gray-400">Upload an Excel (.xlsx) or CSV file to add products in bulk</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <div class="p-3 bg-green-50 border border-green-200 rounded-lg text-xs text-green-700 flex items-center space-x-2">
            <i class="fas fa-check-circle text-green-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-700 space-y-1">
            @foreach($errors->all() as $error)
                <div class="flex items-center space-x-2">
                    <i class="fas fa-exclamation-circle text-rose-500"></i>
                    <span>{{ $error }}</span>
                </div>
            @endforeach
        </div>
    @endif

    @if(session('import_failed_rows'))
        <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
            <p class="text-xs font-semibold text-amber-700 mb-2 flex items-center space-x-2">
                <i class="fas fa-info-circle"></i><span>Skipped Rows</span>
            </p>
            <ul class="text-[11px] text-amber-700 list-disc list-inside space-y-1 max-h-40 overflow-y-auto">
                @foreach(session('import_failed_rows') as $row)
                    <li>{{ $row }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Upload Card --}}
    <div class="bg-white rounded-xl border border-cyan-100/50 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-purple-50 via-cyan-50 to-emerald-50 border-b border-cyan-100/50">
            <h4 class="text-sm font-semibold text-gray-700 flex items-center space-x-2">
                <i class="fas fa-cloud-upload-alt text-purple-500"></i><span>Upload File</span>
            </h4>
        </div>

        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-2">Select file</label>
                <div class="flex items-center space-x-3">
                    <input type="file" name="file" accept=".xlsx,.csv" required
                           class="w-full text-xs text-gray-700 border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-cyan-300 focus:ring-1 focus:ring-cyan-100">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-cyan-500 text-white text-xs font-medium rounded-lg hover:from-purple-600 hover:to-cyan-600 transition-all duration-200 shadow-sm">
                        <i class="fas fa-upload mr-2"></i>Import
                    </button>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Allowed: .xlsx or .csv, max 2 MB.</p>
                <a href="{{ route('products.import.template') }}" class="inline-flex items-center text-[11px] text-purple-600 hover:text-purple-700 mt-2">
                    <i class="fas fa-download mr-1"></i> Download sample format (CSV)
                </a>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                    <h5 class="text-[11px] font-semibold text-gray-700 mb-2">Required Columns</h5>
                    <ul class="text-[11px] text-gray-600 space-y-1 list-disc list-inside">
                        <li>product_name</li>
                        <li>unit_price</li>
                        <li>stock_quantity</li>
                    </ul>
                    <p class="text-[10px] text-gray-400 mt-2">Heading row must be the first row. Column names are case-insensitive.</p>
                </div>

                <div class="bg-gray-50 border border-gray-100 rounded-lg p-4">
                    <h5 class="text-[11px] font-semibold text-gray-700 mb-2">Optional Columns</h5>
                    <p class="text-[11px] text-gray-600 leading-5">
                        sku, description, category_id, sub_category_id, sub_sub_category_id, brand_id, product_type, discount, discount_type, product_unit, shipping_cost, tax_amount, attribute_id, attribute_value, tags (comma separated), status (1/0)
                    </p>
                </div>
            </div>

            <div class="bg-white border border-dashed border-cyan-200 rounded-lg p-4">
                <h5 class="text-[11px] font-semibold text-gray-700 mb-2">Sample Header</h5>
                <div class="bg-gray-900 text-gray-100 text-[11px] font-mono rounded-md p-3 overflow-x-auto">
<code>product_name,sku,description,unit_price,stock_quantity,category_id,sub_category_id,sub_sub_category_id,brand_id,product_type,discount,discount_type,product_unit,shipping_cost,tax_amount,attribute_id,attribute_value,tags,status</code>
                </div>
                <p class="text-[10px] text-gray-400 mt-2">Tags field accepts comma separated values (e.g. <code>home,decor</code>).</p>
            </div>
        </form>
    </div>
</div>
@endsection
