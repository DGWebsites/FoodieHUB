<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DriverDashboardController extends Controller
{
    public function index()
    {
        $driverId = Auth::id();





        

      $assignedOrders = Order::where('driver_id', $driverId)
    ->whereNotIn('status', [
        'Cancelled',
        'Rejected',
    ])
    ->orderByDesc('driver_assigned_at')
    ->orderByDesc('id')
    ->get();









        $assignedCount = $assignedOrders->count();

        $outForDeliveryCount = Order::where('driver_id', $driverId)
            ->where('status', 'Out for Delivery')
            ->count();

        $deliveredCount = Order::where('driver_id', $driverId)
            ->whereIn('status', [
                'Delivered',
                'Completed',
            ])
            ->count();

        return view('driver.dashboard', [
            'assignedOrders' => $assignedOrders,
            'assignedCount' => $assignedCount,
            'outForDeliveryCount' => $outForDeliveryCount,
            'deliveredCount' => $deliveredCount,
        ]);
    }
}