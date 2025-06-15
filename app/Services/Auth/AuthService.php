<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->only('name', 'email', 'password');
        $user = User::create($validated);
        if ($user) {
            Auth::login($user);
            return to_route('home')->with('success', "Registered successfully");
        }
        return back()->withErrors(['message' => "Something wrong"]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return to_route('home')->with('success', 'Logged in successfully');
        } elseif (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return to_route('dashboard')->with('success', 'Logged in successfully');
        }
        return back()->withErrors(['message' => "Invalid credentials"]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->invalidate();
        return to_route('home')->with('success', 'Logged out successfully');
    }
}
