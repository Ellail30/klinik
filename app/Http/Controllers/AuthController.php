<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $users = User::where('username', $request->username)->first();

        if ($users && Hash::check($request->password, $users->password)) {
            session(['user' => $users]);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['login_error' => 'Username atau password salah']);
    }

    public function dashboard()
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        return view('dashboard', ['user' => session('user')]);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login');
    }
}
