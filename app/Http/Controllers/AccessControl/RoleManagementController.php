<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Permission;

class RoleManagementController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions', 'creator', 'updater'])->get();

        $permissions = Permission::where('is_active', 1)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        return view('pages.access_control.roles', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:50',
        'regex:/^[a-zA-Z0-9_\-]+$/',
        Rule::unique('roles', 'name'),
    ],
    'guard_name' => [
        'required',
        'in:web,api',
    ],
    'permissions' => [
        'required',
        'array',
        'min:1',
    ],
    'permissions.*' => [
        Rule::exists('permissions', 'id'),
    ],
]);

        try {
            $role = Role::create([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
                'created_by' => Auth::id(),
            ]);

            $permissionNames = Permission::whereIn('id', $request->permissions)
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissionNames);

            return back()->with('success', __('Role has been successfully created and permissions assigned.'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to create role: ') . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
$request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:50',
        'regex:/^[a-zA-Z0-9_\-]+$/',
        Rule::unique('roles', 'name')->ignore($id),
    ],
    'guard_name' => [
        'required',
        'in:web,api',
    ],
    'permissions' => [
        'required',
        'array',
        'min:1',
    ],
    'permissions.*' => [
        Rule::exists('permissions', 'id'),
    ],
]);


        try {
            $role = Role::findOrFail($id);

            $role->update([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
                'updated_by' => Auth::id(),
            ]);

            $permissionNames = Permission::whereIn('id', $request->permissions)
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissionNames);

            return back()->with('success', __('Role successfully updated.'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to update role: ') . $e->getMessage());
        }
    }

    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:roles,id',
            'status' => 'required|in:activate,deactivate',
        ]);

        $role = Role::findOrFail($request->id);

        $role->update([
            'is_active'  => $request->status === "activate" ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Role status updated successfully.')
        ]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => __('Role has been archived.')
        ]);
    }
}