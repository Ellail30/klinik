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
            'role' => 'required|string',
            'password' => 'required|min:6',
        ]);

        // Generate role-based ID
        $role_prefix = $this->getRolePrefix($request->role);
        $role_id = $this->generateRoleId($role_prefix);

        User::create([
            'id' => Str::uuid(),
            'role_id' => $role_id,
            'username' => $request->username,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('config_user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function destroy($username)
    {
        // Cari user berdasarkan username, bukan ID
        $users = User::where('username', $username)->firstOrFail();

        $users->delete();

        return redirect()->route('config_user.index')->with('success', 'User berhasil dihapus');
    }

    // Helper methods for role-based ID generation
    private function getRolePrefix($role)
    {
        $prefixes = [
            'Dokter' => 'DR',
            'Apoteker' => 'APT',
            'Pimpinan' => 'PMP',
        ];

        return $prefixes[$role] ?? substr(strtoupper($role), 0, 3);
    }

    private function generateRoleId($prefix)
    {
        // Find the last role ID with this prefix
        $lastUser = User::where('role_id', 'like', $prefix . '%')
                        ->orderBy('role_id', 'desc')
                        ->first();

        if ($lastUser) {
            // Extract the number part and increment it
            $lastNumber = (int) substr($lastUser->role_id, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            // If no existing users with this prefix, start with 1
            $newNumber = 1;
        }

        // Format with leading zeros (e.g., APT001)
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
