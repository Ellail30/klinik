<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ConfigUsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query, $search) {
            return $query->where('username', 'like', "%{$search}%")
                         ->orWhere('role', 'like', "%{$search}%");
        })->paginate(5);

        return view('config_user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'role' => 'required|string', // Gunakan string agar fleksibel
            'password' => 'required|min:6',
        ]);

        User::create([
            'id' => Str::uuid(),
            'username' => $request->username,
            'role' => $request->role,
            'password' => Hash::make($request->password), // Tanpa "value:"
        ]);
        return redirect()->route('config_user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function destroy($username)
    {
        // Cari user berdasarkan username, bukan ID
        $user = User::where('username', $username)->firstOrFail();

        $user->delete();

        return redirect()->route('config_user.index')->with('success', 'User berhasil dihapus');
    }
}
