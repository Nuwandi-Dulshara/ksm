<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();
        $totalRoles = Role::count();

        return view('roles.index', compact('roles', 'totalRoles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $totalRoles = Role::count();
        $sections = $this->getSidebarSections();

        return view('roles.create', compact('totalRoles', 'sections'));
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

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->permissions) {
            foreach ($request->permissions as $section => $perms) {
                Permission::create([
                    'role_id' => $role->id,
                    'section' => $section,
                    'can_create' => isset($perms['create']),
                    'can_read' => isset($perms['read']),
                    'can_update' => isset($perms['update']),
                    'can_delete' => isset($perms['delete']),
                ]);
            }
        }

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
        $permissions = $role->permissions->mapWithKeys(function ($permission) {
            return [$this->normalizeSectionName($permission->section) => $permission];
        });
        $sections = collect($this->getSidebarSections())
            ->merge($permissions->keys())
            ->unique()
            ->values();

        return view('roles.edit', compact('role', 'totalRoles', 'sections', 'permissions'));
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

        $role->permissions()->delete();

        if ($request->permissions) {
            foreach ($request->permissions as $section => $perms) {
                Permission::create([
                    'role_id' => $role->id,
                    'section' => $section,
                    'can_create' => isset($perms['create']),
                    'can_read' => isset($perms['read']),
                    'can_update' => isset($perms['update']),
                    'can_delete' => isset($perms['delete']),
                ]);
            }
        }

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        $role->permissions()->delete();
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    private function getSidebarSections(): array
    {
        return [
            'Dashboard',
            'Incomes',
            'Expense Types',
            'Expense Categories',
            'Outcomes ++',
            'Outcome Report',
            'Approval History',
            'Summary of Outcome',
            'Employees',
            'Donators',
            'Users',
            'Roles',
        ];
    }

    private function normalizeSectionName(string $section): string
    {
        $legacyMap = [
            'dashboard' => 'Dashboard',
            'income' => 'Incomes',
            'income.index' => 'Incomes',
            'expense-types.index' => 'Expense Types',
            'expense-categories.index' => 'Expense Categories',
            'outcomes.index' => 'Outcomes ++',
            'outcomes.create' => 'Outcomes ++',
            'outcomes.store' => 'Outcomes ++',
            'outcomes.edit' => 'Outcomes ++',
            'outcomes.update' => 'Outcomes ++',
            'outcomes.destroy' => 'Outcomes ++',
            'outcome-report.index' => 'Outcome Report',
            'approval.history' => 'Approval History',
            'category.summary' => 'Summary of Outcome',
            'employees.index' => 'Employees',
            'employees.create' => 'Employees',
            'employees.store' => 'Employees',
            'employees.edit' => 'Employees',
            'employees.update' => 'Employees',
            'employees.destroy' => 'Employees',
            'donators.index' => 'Donators',
            'donators.create' => 'Donators',
            'donators.store' => 'Donators',
            'donators.edit' => 'Donators',
            'donators.update' => 'Donators',
            'donators.destroy' => 'Donators',
            'users.index' => 'Users',
            'users.create' => 'Users',
            'users.store' => 'Users',
            'users.edit' => 'Users',
            'users.update' => 'Users',
            'users.destroy' => 'Users',
            'roles.index' => 'Roles',
            'roles.create' => 'Roles',
            'roles.store' => 'Roles',
            'roles.edit' => 'Roles',
            'roles.update' => 'Roles',
            'roles.destroy' => 'Roles',
        ];

        return $legacyMap[$section] ?? $section;
    }
}
