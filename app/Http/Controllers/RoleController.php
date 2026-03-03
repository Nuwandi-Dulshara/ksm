<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::latest()->get();
        $totalRoles = Role::count();

        return view('roles.index', compact('roles', 'totalRoles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $totalRoles = Role::count();

        return view('roles.create', compact('totalRoles'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string',
        ]);

        Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $totalRoles = Role::count();

        return view('roles.edit', compact('role', 'totalRoles'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}