<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAuthController extends Controller
{
    public function showLogin()
    {
        return view('driver.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $authenticated = Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => 'driver',
        ]);

        if (!$authenticated) {
            return back()
                ->withErrors([
                    'email' => 'Invalid driver credentials.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('driver.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('driver.login');
    }
}