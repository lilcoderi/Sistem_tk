<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index(Request $request)
{
    $roleFilter = $request->input('role');
    $roles = Role::all();

    $query = User::with('roles');

    if ($roleFilter) {
        $query->whereHas('roles', function ($q) use ($roleFilter) {
            $q->where('name', $roleFilter);
        });
    }

    $users = $query->get();

    return view('kepala_sekolah.pengguna.akun.index', compact('users', 'roles', 'roleFilter'));
}


    public function edit(User $user)
    {
        $roles = Role::all();
        return view('kepala_sekolah.pengguna.akun.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('user.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function create()
    {
        $roles = Role::all();
        return view('kepala_sekolah.pengguna.akun.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|exists:roles,name',
    ]);

    $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
    ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

public function getUser($id)
{
    $user = User::findOrFail($id);
    return response()->json([
        'name' => $user->name,
        'email' => $user->email,
    ]);
}

}

