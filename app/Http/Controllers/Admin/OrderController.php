<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\FoodieHubNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = trim($request->input('status', ''));
        $driverId = trim($request->input('driver_id', ''));

        // Allow searches like "#12" or "12".
        $cleanSearch = ltrim($search, '# ');

        $query = Order::with('user', 'driver')
            ->withCount('orderItems')
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        | Search by:
        | - Order number
        | - Customer name
        | - Customer email
        | - Customer phone
        */

        if ($cleanSearch !== '') {
            $query->where(function ($q) use ($cleanSearch) {

                $q->where('id', 'like', '%' . $cleanSearch . '%')

                    ->orWhere('full_name', 'like', '%' . $cleanSearch . '%')

                    ->orWhere('phone', 'like', '%' . $cleanSearch . '%')

                    ->orWhereHas('user', function ($userQuery) use ($cleanSearch) {

                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $cleanSearch . '%'
                        );

                        $userQuery->orWhere(
                            'email',
                            'like',
                            '%' . $cleanSearch . '%'
                        );
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        if ($status !== '') {
            $query->where('status', $status);
        }

        /*
        |--------------------------------------------------------------------------
        | DRIVER FILTER
        |--------------------------------------------------------------------------
        */

        if ($driverId !== '') {

            if ($driverId === 'unassigned') {

                $query->whereNull('driver_id');

            } else {

                $query->where('driver_id', $driverId);

            }
        }

        $orders = $query->get();

        /*
        |--------------------------------------------------------------------------
        | DRIVER LIST
        |--------------------------------------------------------------------------
        */

        $drivers = User::where('role', 'driver')
            ->orderBy('name')
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'drivers' => $drivers,
            'search' => $search,
            'status' => $status,
            'driverId' => $driverId,
        ]);
    }

    public function show(Order $order)
    {
        $order->load([
            'user',
            'driver',
            'orderItems.product',
        ]);

        $drivers = User::where('role', 'driver')
            ->where('is_active', true)
            ->withCount([
                'assignedOrders as active_orders_count' => function ($query) {
                    $query->whereNotIn('status', [
                        'Delivered',
                        'Completed',
                        'Cancelled',
                        'Rejected',
                    ]);
                },
            ])
            ->orderBy('active_orders_count')
            ->orderBy('name')
            ->get();

        $currentDriver = $order->driver;

        return view('admin.orders.show', [
            'order' => $order,
            'drivers' => $drivers,
            'currentDriver' => $currentDriver,
        ]);
    }

    public function updateStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:Pending,Confirmed,Preparing,Ready,Out for Delivery,Delivered,Completed,Cancelled,Rejected',
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Order status updated successfully.'
            );
    }

    public function assignDriver(
        Request $request,
        Order $order
    ) {
        $driverId = $request->input('driver_id');

        if ($driverId === null || $driverId === '') {
            $order->update([
                'driver_id' => null,
                'driver_assigned_at' => null,
            ]);

            return redirect()
                ->route('admin.orders.show', $order)
                ->with(
                    'success',
                    'Driver assignment removed.'
                );
        }

        $driver = User::where('id', $driverId)
            ->where('role', 'driver')
            ->where('is_active', true)
            ->first();

        if (!$driver) {
            return back()
                ->withErrors([
                    'driver_id' =>
                        'The selected driver is inactive or is not a valid driver.',
                ]);
        }

        $assignmentChanged =
            $order->driver_id !== $driver->id;

        $order->update([
            'driver_id' => $driver->id,
            'driver_assigned_at' => now(),
        ]);

        if ($assignmentChanged) {
            $driver->notify(
                new FoodieHubNotification(
                    'New Delivery Assigned',
                    'Order #' . $order->id .
                    ' has been assigned to you for delivery.',
                    'driver',
                    route('driver.dashboard')
                )
            );
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with(
                'success',
                'Driver assigned successfully.'
            );
    }
}