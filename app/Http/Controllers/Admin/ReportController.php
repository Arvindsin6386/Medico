<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // ✅ DASHBOARD - overview of all reports 
    public function index()
    {
        // Sales summary
        $totalSalesAmount  = Sale::whereMonth('sale_date', now()->month)->sum('total_amount');
        $totalOrders       = Sale::whereMonth('sale_date', now()->month)->count();

        // Inventory summary (using your 'stock' column)
        $lowStockCount     = Medicine::lowStock(10)->count();
        $outOfStockCount   = Medicine::outOfStock()->count();

        // Expiry summary (using your 'expiry_data' column)
        $expiringCount     = Medicine::expiringSoon(30)->count();
        $expiredCount      = Medicine::alreadyExpired()->count();

        // Top 5 selling medicines this month
        $topMedicines = Sale::with('medicine') // Eager Loading avoide N+1 query
            ->selectRaw('medicine_id, SUM(total_amount) as revenue, SUM(quantity_sold) as total_qty')
            ->whereMonth('sale_date', now()->month)
            ->groupBy('medicine_id')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        // Medicines expiring in next 30 days
        $expiringList = Medicine::with('category')
            ->expiringSoon(30)
            ->orderBy('expiry_data')
            ->limit(8)
            ->get();

        // Low stock medicines
        $lowStockList = Medicine::with('category')
            ->lowStock(10)
            ->orderBy('stock')
            ->limit(8)
            ->get();

        return view('admin.reports.index', compact(
            'totalSalesAmount', 'totalOrders',
            'lowStockCount', 'outOfStockCount',
            'expiringCount', 'expiredCount',
            'topMedicines', 'expiringList', 'lowStockList'
        ));
    }

    // ✅ SALES REPORT
    public function sales(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $sales = Sale::with('medicine')
            ->whereBetween('sale_date', [$from, $to])
            ->when($request->medicine_id, fn($q) => $q->where('medicine_id', $request->medicine_id))
            ->latest('sale_date')
            ->paginate(20);

        $totalRevenue  = Sale::whereBetween('sale_date', [$from, $to])->sum('total_amount');
        $totalQtySold  = Sale::whereBetween('sale_date', [$from, $to])->sum('quantity_sold');
        $medicines     = Medicine::orderBy('name')->get();

        return view('admin.reports.sales', compact(
            'sales', 'totalRevenue', 'totalQtySold', 'from', 'to', 'medicines'
        ));
    }

    // ✅ INVENTORY REPORT (uses stock, price, category_id from your table)
    public function inventory(Request $request)
    {
        $medicines = Medicine::with(['category', 'subcategory'])
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->company, fn($q) => $q->where('company', 'like', "%{$request->company}%"))
            ->when($request->filter === 'low_stock',   fn($q) => $q->lowStock(10))
            ->when($request->filter === 'out_of_stock', fn($q) => $q->outOfStock())
            ->orderBy('stock')
            ->paginate(20);

        $categories       = Category::orderBy('name')->get();
        $totalStockValue  = Medicine::sum(\DB::raw('stock * price'));

        return view('admin.reports.inventory', compact(
            'medicines', 'categories', 'totalStockValue'
        ));
    }

    // ✅ EXPIRY REPORT (uses your exact 'expiry_data' column)
    public function expiry(Request $request)
    {
        $days   = $request->days ?? 30;
        $filter = $request->filter ?? 'expiring'; // expiring or expired

        $medicines = Medicine::with('category')
            ->when($filter === 'expiring', fn($q) => $q->expiringSoon($days))
            ->when($filter === 'expired',  fn($q) => $q->alreadyExpired())
            ->orderBy('expiry_data')
            ->paginate(20);

        return view('admin.reports.expiry', compact('medicines', 'days', 'filter'));
    }

    // ✅ PURCHASE REPORT
    public function purchases(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth()->toDateString();
        $to   = $request->to   ?? now()->toDateString();

        $purchases = Purchase::with('medicine')
            ->whereBetween('purchase_date', [$from, $to])
            ->when($request->medicine_id, fn($q) => $q->where('medicine_id', $request->medicine_id))
            ->latest('purchase_date')
            ->paginate(20);

        $totalCost = Purchase::whereBetween('purchase_date', [$from, $to])->sum('total_cost');
        $medicines = Medicine::orderBy('name')->get();

        return view('admin.reports.purchases', compact(
            'purchases', 'totalCost', 'from', 'to', 'medicines'
        ));
    }

    // ✅ PROFIT & LOSS REPORT
    public function profit(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year  = $request->year  ?? now()->year;

        $revenue = Sale::whereMonth('sale_date', $month)
                       ->whereYear('sale_date', $year)
                       ->sum('total_amount');

        $cost    = Purchase::whereMonth('purchase_date', $month)
                           ->whereYear('purchase_date', $year)
                           ->sum('total_cost');

        $profit  = $revenue - $cost;
        $margin  = $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0;

        return view('admin.reports.profit', compact(
            'revenue', 'cost', 'profit', 'margin', 'month', 'year'
        ));
    }
}
