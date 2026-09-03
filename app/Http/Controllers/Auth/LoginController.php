<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (!Auth::user()->hasVerifiedEmail()) {
                Auth::user()->sendEmailVerificationNotification();
                return redirect()->route('verification.notice')
                    ->with('warning', 'Please verify your email address.');
            }

            // Redirect based on role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }
            
            if (Auth::user()->isSeller()) {
                return redirect()->route('seller.dashboard')->with('success', 'Welcome back, Seller!');
            }

            return redirect()->route('home')->with('success', 'Welcome back!');
        }

        throw ValidationException::withMessages([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}