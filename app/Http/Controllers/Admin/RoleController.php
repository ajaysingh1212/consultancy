<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role.view')->only('index');
        $this->middleware('permission:role.create')->only(['create', 'store']);
        $this->middleware('permission:role.edit')->only(['edit', 'update']);
        $this->middleware('permission:role.delete')->only('destroy');
    }

    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store new role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Show edit form
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view(
            'admin.roles.edit',
            compact('role', 'permissions', 'rolePermissions')
        );
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }
    /**
 * Display the specified role
 */
    public function show(Role $role)
    {
        // permissions eager load
        $role->load('permissions');

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Delete role
     */
    public function destroy(Role $role)
    {
        // Optional safety: don't delete Super Admin
        if ($role->name === 'Super Admin') {
            abort(403, 'Super Admin role cannot be deleted');
        }

        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
}
