<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isEmployee()) {
                return redirect()->route('employee.dashboard');
            }
        }
        return view('login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isEmployee()) {
                return redirect()->route('employee.dashboard');
            }
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}