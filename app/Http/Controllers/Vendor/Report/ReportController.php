<?php

namespace App\Http\Controllers\Vendor\Report;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
    private array $reportStatuses = ['pending', 'confirmed', 'delivered', 'cancelled'];

    private function vendorOrdersQuery(array $vendor, Request $request): Builder
    {
        $query = Order::with(['customer', 'product'])
            ->where('vendor_id', $vendor['id']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function (Builder $nested) use ($search) {
                $nested->where('order_no', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function (Builder $customerQuery) use ($search) {
                        $customerQuery->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('product', function (Builder $productQuery) use ($search) {
                        $productQuery->where('product_name', 'like', '%' . $search . '%');
                    });
            });
        }

        return $query;
    }

    private function statusCountsForVendor(array $vendor): array
    {
        $counts = Order::where('vendor_id', $vendor['id'])
            ->groupBy('status')
            ->selectRaw('status, COUNT(*) as count')
            ->pluck('count', 'status')
            ->toArray();

        return array_merge(array_fill_keys($this->reportStatuses, 0), $counts);
    }

    public function index(Request $request)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $statusCounts = $this->statusCountsForVendor($vendor);

        $orders = $this->vendorOrdersQuery($vendor, $request)->latest()->paginate(15);
        $statusFilter = $request->get('status', 'all');
        
        return view('vendor.report.index', compact('statusCounts', 'orders', 'statusFilter'));
    }

    public function export(Request $request)
    {
        $vendor = session('vendor');
        if (!$vendor) {
            return redirect()->route('vendor.login')->with('error', 'Please login first');
        }

        $statusFilter = $request->get('status', 'all');

        $statusCounts = $this->statusCountsForVendor($vendor);

        $orders = $this->vendorOrdersQuery($vendor, $request)->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('vendor.report.export', compact('statusCounts', 'orders', 'statusFilter'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('aerthh-vendor-order-report-' . date('Y-m-d') . '.pdf');
    }

}
