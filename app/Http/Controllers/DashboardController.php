<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            return $this->adminDashboard();
        }
        
        return $this->clientDashboard();
    }

    private function adminDashboard()
    {
        // Statistici de bază
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'client')->count();
        
        // Venituri
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // Comenzi recente
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
        
        // Comenzi pe status
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        
        // Top 5 produse cele mai vândute
        $topProducts = DB::table('order_items')
            ->select('product_id', 'product_title', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->groupBy('product_id', 'product_title')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Produse cu stoc scăzut (sub 10 bucăți)
        $lowStockProducts = Product::where('stock', '<', 10)
            ->where('is_active', true)
            ->orderBy('stock')
            ->take(5)
            ->get();
        
        // Vânzări lunare (ultimele 6 luni)
        $monthlySales = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'activeProducts',
            'totalOrders',
            'totalUsers',
            'totalRevenue',
            'monthlyRevenue',
            'recentOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'topProducts',
            'lowStockProducts',
            'monthlySales'
        ));
    }

    private function clientDashboard()
    {
        // Statistici pentru client
        $totalOrders = Order::where('user_id', auth()->id())->count();
        $pendingOrders = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->count();
        $completedOrders = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->count();
        $totalSpent = Order::where('user_id', auth()->id())
            ->where('payment_status', 'paid')
            ->sum('total_amount');
        
        // Comenzi recente
        $recentOrders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalSpent',
            'recentOrders'
        ));
    }
}