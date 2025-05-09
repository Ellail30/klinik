<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd(Auth::user()->role);
            // Redirect berdasarkan role
            switch (Auth::user()->role) {
                case 'dokter':
                    return redirect()->intended('/dashboard');
                case 'pimpinan':
                    return redirect()->intended('/dashboard');
                case 'apoteker':
                    return redirect()->intended('/dashboard');
                case 'admin':
                    return redirect()->intended('/dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['login_error' => 'Role tidak dikenali']);
            }
        }

        return back()->withErrors(['login_error' => 'Username/email atau password salah'])->withInput();
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     // dd($credentials);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();

    //         $user = Auth::user();

    //         // Redirect berdasarkan role
    //         switch ($user->role) {
    //             case 'dokter':
    //                 return redirect()->route('dashboard');
    //             case 'apoteker':
    //                 return redirect()->route('dashboard');
    //             case 'pimpinan':
    //                 return redirect()->route('dashboard');
    //             default:
    //                 Auth::logout();
    //                 return redirect('/login')->withErrors([
    //                     'username' => 'Role tidak dikenali.',
    //                 ]);
    //         }
    //     }

    //     return back()
    //         ->withErrors([
    //             'username' => 'Username atau password salah.',
    //         ])
    //         ->onlyInput('username');
    // }

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
