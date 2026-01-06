<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Login bisa menggunakan email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (!Auth::attempt([
            $loginType => $request->login,
            'password' => $request->password
        ], $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        // Check if user is active
        if (!Auth::user()->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'login' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        // Check if user has role 'user'
        if (!Auth::user()->hasRole('user')) {
            Auth::logout();
            throw ValidationException::withMessages([
                'login' => 'Akses ditolak. Silakan login melalui portal yang sesuai.',
            ]);
        }

        // Update last login
        Auth::user()->update(['last_login' => now()]);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard.index'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}