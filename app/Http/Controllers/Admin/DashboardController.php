<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();

        $pendingOrders = Order::where(
            'status',
            'Pending'
        )->count();

        $totalProducts = Product::count();

        $availableProducts = Product::where(
            'is_available',
            true
        )->count();

        $totalUsers = User::where(
            'role',
            'user'
        )->count();

        $totalDrivers = User::where(
            'role',
            'driver'
        )->count();

        $totalCategories = Category::count();

        $totalRevenue = Order::whereIn(
            'status',
            [
                'Delivered',
                'Completed',
            ]
        )->sum('total');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'totalProducts' => $totalProducts,
            'availableProducts' => $availableProducts,
            'totalUsers' => $totalUsers,
            'totalDrivers' => $totalDrivers,
            'totalCategories' => $totalCategories,
            'totalRevenue' => $totalRevenue,
            'recentOrders' => $recentOrders,
            'recentProducts' => $recentProducts,
        ]);
    }
}