<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class StoreStatusController extends Controller
{
    public function edit()
    {
        $setting = StoreSetting::first();

        if (!$setting) {
            $setting = StoreSetting::create([
                'is_open' => true,
            ]);
        }

        return view(
            'admin.store-status.index',
            compact('setting')
        );
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:live,closed',
            ],
        ]);

        $setting = StoreSetting::first();

        if (!$setting) {
            $setting = StoreSetting::create([
                'is_open' => true,
            ]);
        }

        $isOpen = $validated['status'] === 'live';

        $setting->update([
            'is_open' => $isOpen,
        ]);

        return redirect()
            ->route('admin.store-status.edit')
            ->with(
                'success',
                $isOpen
                    ? 'FoodieHub is now LIVE and accepting orders.'
                    : 'FoodieHub is now CLOSED and not accepting new orders.'
            );
    }
}