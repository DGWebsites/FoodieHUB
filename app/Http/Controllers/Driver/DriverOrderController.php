<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\FoodieHubNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverOrderController extends Controller
{
    public function updateStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                'in:Out for Delivery,Delivered',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        | Driver can only update an order assigned to themselves.
        */

        if ($order->driver_id !== Auth::id()) {

            abort(
                403,
                'You are not authorized to update this order.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Updates To Finished Orders
        |--------------------------------------------------------------------------
        */

        if (in_array($order->status, [
            'Cancelled',
            'Rejected',
            'Completed',
        ])) {

            return back()->withErrors([
                'status' =>
                    'This order can no longer be updated.',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Control Valid Driver Status Transitions
        |--------------------------------------------------------------------------
        */

        $currentStatus = $order->status;

        $newStatus = $validated['status'];


        if (
            $newStatus === 'Out for Delivery' &&
            $currentStatus !== 'Ready'
        ) {

            return back()->withErrors([
                'status' =>
                    'The order must be Ready before starting delivery.',
            ]);

        }


        if (
            $newStatus === 'Delivered' &&
            $currentStatus !== 'Out for Delivery'
        ) {

            return back()->withErrors([
                'status' =>
                    'The order must be Out for Delivery before marking it as Delivered.',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Update Order Status
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => $newStatus,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Admin When Delivered
        |--------------------------------------------------------------------------
        */

        if ($newStatus === 'Delivered') {

            $driverName = Auth::user()->name;


            $admins = User::where(
                'role',
                'admin'
            )->get();


            foreach ($admins as $admin) {

                $admin->notify(
                    new FoodieHubNotification(
                        'Order Delivered',
                        'Order #' .
                        $order->id .
                        ' was marked as delivered by ' .
                        $driverName .
                        '.',
                        'success',
                        route(
                            'admin.orders.show',
                            $order
                        )
                    )
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Success Message
        |--------------------------------------------------------------------------
        */

        $message =
            $newStatus === 'Out for Delivery'
                ? 'Order #' .
                    $order->id .
                    ' is now Out for Delivery.'
                : 'Order #' .
                    $order->id .
                    ' has been marked as Delivered.';


        return redirect()
            ->route('driver.dashboard')
            ->with(
                'success',
                $message
            );
    }


    public function cancel(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'cancellation_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        | Driver can only cancel an order assigned to themselves.
        */

        if ($order->driver_id !== Auth::id()) {

            abort(
                403,
                'You are not authorized to cancel this order.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Invalid Cancellations
        |--------------------------------------------------------------------------
        */

        if (in_array($order->status, [
            'Delivered',
            'Completed',
            'Cancelled',
            'Rejected',
        ])) {

            return back()->withErrors([
                'cancellation_reason' =>
                    'This order can no longer be cancelled.',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | Cancel Order
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => 'Cancelled',

            'cancellation_reason' =>
                $validated['cancellation_reason'],

            'cancelled_by' =>
                'Driver - ' . Auth::user()->name,

            'cancelled_at' => now(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Notify Admin About Driver Cancellation
        |--------------------------------------------------------------------------
        */

        $driverName = Auth::user()->name;


        $reason =
            $validated['cancellation_reason'];


        $admins = User::where(
            'role',
            'admin'
        )->get();


        foreach ($admins as $admin) {

            $admin->notify(
                new FoodieHubNotification(
                    'Driver Cancelled Order',
                    'Driver - ' .
                    $driverName .
                    ' cancelled Order #' .
                    $order->id .
                    '. Reason: ' .
                    $reason,
                    'warning',
                    route(
                        'admin.orders.show',
                        $order
                    )
                )
            );

        }


        return redirect()
            ->route('driver.dashboard')
            ->with(
                'success',
                'Order #' .
                $order->id .
                ' has been cancelled successfully.'
            );
    }
}