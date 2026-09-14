<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:supervisor,teknisi,manajer'],
        ]);

        $role = $credentials['role'];
        unset($credentials['role']);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            if (Auth::user()->role !== $role) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun tersebut tidak terdaftar sebagai ' . ucfirst($role) . '.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect()->route('welcome');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->withInput($request->except('password'));
    }

    public function welcome()
    {
        return view('auth.welcome', ['user' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('splash');
    }
}
