<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')
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
            ->orderBy('name')
            ->get();

        return view('admin.drivers.index', [
            'drivers' => $drivers,
        ]);
    }


    public function create()
    {
        return view('admin.drivers.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);


        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make(
                $validated['password']
            ),
            'role' => 'driver',
            'is_active' => true,
        ]);


        return redirect()
            ->route('admin.drivers.index')
            ->with(
                'success',
                'Driver account created successfully.'
            );
    }


    public function toggleStatus(User $driver)
    {
        if ($driver->role !== 'driver') {
            abort(
                404,
                'Driver account not found.'
            );
        }


        $driver->update([
            'is_active' => !$driver->is_active,
        ]);


        $message = $driver->is_active
            ? $driver->name . ' is now active.'
            : $driver->name . ' has been set to inactive.';


        return redirect()
            ->route('admin.drivers.index')
            ->with(
                'success',
                $message
            );
    }
}