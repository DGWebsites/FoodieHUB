<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function open(
        Request $request,
        string $notification
    ): RedirectResponse {
        $user = $request->user();

        $userNotification = $user->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $userNotification->markAsRead();

        $url = $userNotification->data['url'] ?? null;

        if ($url) {
            return redirect()->to($url);
        }

        return redirect()->route('home');
    }


    public function markAllAsRead(
        Request $request
    ): RedirectResponse {
        $request->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back();
    }
}