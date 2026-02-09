<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission.view')->only(['index', 'show']);
        $this->middleware('permission:permission.create')->only(['create', 'store']);
        $this->middleware('permission:permission.edit')->only(['edit', 'update']);
        $this->middleware('permission:permission.delete')->only('destroy');
    }

    /**
     * Display a listing of permissions
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    /**
     * Display the specified permission
     */
    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission)
    {
        // Safety: prevent deleting core permissions if you want
        if (in_array($permission->name, [
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
        ])) {
            abort(403, 'Core permissions cannot be deleted');
        }

        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully');
    }
}
