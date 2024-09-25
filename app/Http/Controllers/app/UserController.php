<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use App\Models\{
    Tenant,
    User
};
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();

        return view('app.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);


        User::create($validatedData);


        return redirect()->route('tenant.user');

    }

    public function show(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('app.user.role', compact('user', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('success-trash', 'Role exists.');
        }

        $user->assignRole($request->role);
        return back()->with('success', 'Role assigned.');
    }

    public function removeRole(User $user, Role $role)
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            return back()->with('success-delete', 'Role removed.');
        }

        return back()->with('success', 'Role not exists.');
    }

    public function givePermission(Request $request, User $user)
    {
        if ($user->hasPermissionTo($request->permission)) {
            return back()->with('success-trash', 'Permission exists.');
        }
        $user->givePermissionTo($request->permission);
        return back()->with('success', 'Permission added.');
    }

    public function revokePermission(User $user, Permission $permission)
    {
        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
            return back()->with('success-delete', 'Permission revoked.');
        }
        return back()->with('success', 'Permission does not exists.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('success-trash', 'you are admin.');
        }
        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
