<?php

namespace App\Http\Controllers\super_admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalOrders = Order::where('status','!=', 'decline')->count();
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalRevenus = Order::where('status','!=', 'decline')->sum('grand_total');
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $currentDate = Carbon::now()->format('Y-m-d');
        $revenueThisMonth = Order::where('status','!=', 'decline')
            ->whereDate('created_at', '>=', $startOfMonth)
            ->whereDate('created_at', '<=', $currentDate)
            ->sum('grand_total');
        // Last month
        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('M');
        $revenueLastMonth = Order::where('status','!=', 'decline')
            ->whereDate('created_at', '>=', $lastMonthStartDate)
            ->whereDate('created_at', '<=', $lastMonthEndDate)
            ->sum('grand_total');
        // Monthly revenue
        $monthlyRevenue = Order::where('status', '!=', 'decline')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->pluck('total', 'month');
        $monthlyChartData = collect(range(1, 12))->map(function ($month) use ($monthlyRevenue) {
            return $monthlyRevenue[$month] ?? 0;
        });
        // Products
        $products = Product::latest('id')->with('product_images');
        if ($request->filled('keyword_product')) {
            $products->where('title', 'like', '%' . $request->keyword_product . '%');
        }
        $products = $products->paginate();
        // Orders
        $orders = Order::latest('orders.created_at')
            ->select('orders.*', 'users.name', 'users.email')
            ->leftJoin('users', 'users.id', 'orders.user_id');

        if ($request->filled('keyword_order')) {
            $orders->where(function ($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->keyword_order . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword_order . '%')
                    ->orWhere('orders.id', 'like', '%' . $request->keyword_order . '%');
            });
        }
        $orders = $orders->paginate(10);
        $statCards = [
            [
                'label' => 'Total Orders',
                'value' => $totalOrders,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'bg-primary',
            ],
            [
                'label' => 'Total Products',
                'value' => $totalProducts,
                'icon' => 'fas fa-box-open',
                'color' => 'bg-success',
            ],
            [
                'label' => 'Total Users',
                'value' => $totalUsers,
                'icon' => 'fas fa-users',
                'color' => 'bg-info',
            ],
            [
                'label' => 'Total Sale',
                'value' => number_format($totalRevenus, 0, ',', '.') . ' VND',
                'icon' => 'fas fa-dollar-sign',
                'color' => 'bg-warning',
            ],
            [
                'label' => 'This Month',
                'value' => number_format($revenueThisMonth, 0, ',', '.') . ' VND',
                'icon' => 'fas fa-calendar-alt',
                'color' => 'bg-danger',
            ],
            [
                'label' => "Last Month ($lastMonthName)",
                'value' => number_format($revenueLastMonth, 0, ',', '.') . ' VND',
                'icon' => 'fas fa-chart-line',
                'color' => 'bg-secondary',
            ],
        ];
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'decline' => Order::where('status', 'decline')->count(),
        ];
        $categoryStats = Category::withCount('products')->get()->pluck('products_count', 'name');
        $data['orders'] = $orders;
        $data['products'] = $products ;
        $data['categoryLabels'] = $categoryStats->keys();
        $data['categoryData'] = $categoryStats->values();
        $data['statCards'] = $statCards;
        $data['orderStats'] = $orderStats;
        $data['monthlyChartData'] = $monthlyChartData;
        $data['totalOrders'] = $totalOrders;
        $data['totalProducts'] = $totalProducts;
        $data['totalUsers'] = $totalUsers;
        $data['totalRevenus'] = $totalRevenus;
        $data['revenueThisMonth'] = $revenueThisMonth;
        $data['revenueLastMonth'] = $revenueLastMonth;
        $data['lastMonthName'] = $lastMonthName;
        return view('super_admin.dashboard.dashboard', $data);
    }
}
