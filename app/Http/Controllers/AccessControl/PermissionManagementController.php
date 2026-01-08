<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;

class PermissionManagementController extends Controller
{
    // show all permissions with relations
    public function index()
    {
        // get permissions with related roles and user info
        $permissions = Permission::with(['roles', 'creator', 'updater'])->get();

        // render view with data
        return view('pages.access_control.permissions', compact('permissions'));
    }

    // create new permission
    public function store(Request $request)
    {
        // validate input fields
$request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z0-9_\-\.\/]+$/',
        Rule::unique('permissions', 'name')
            ->where(fn ($query) =>
                $query->where('guard_name', $request->guard_name)
            ),
    ],
    'guard_name' => [
        'required',
        'string',
        'in:web,api',
    ],
], [
    'name.required' => __('Permission name is required.'),
    'name.regex' => __('Permission name contains invalid characters.'),
    'name.unique' => __('A permission with this Name & Guard combination already exists.'),
    'guard_name.required' => __('Guard is required.'),
    'guard_name.in' => __('Invalid guard selected.'),
]);

        try {
            // save permission record
            Permission::create([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
                'created_by' => Auth::id(),
            ]);

            // success feedback
            return redirect()->back()->with('success', __('Permission has been successfully created.'));

        } catch (\Exception $e) {
            // handle exception
            return redirect()->back()->with('error', __('Failed to create permission: ') . $e->getMessage());
        }
    }

    // update permission by id
    public function update(Request $request, $id)
    {

// validate request input
$request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z0-9_\-\.\/]+$/',
        Rule::unique('permissions', 'name')
            ->where(fn ($query) =>
                $query->where('guard_name', $request->guard_name)
            )
            ->ignore($id),
    ],
    'guard_name' => [
        'required',
        'string',
        'in:web,api',
    ],
], [
    'name.required' => __('Permission name is required.'),
    'name.regex' => __('Permission name contains invalid characters.'),
    'name.unique' => __('A permission with this Name & Guard combination is already registered.'),
    'guard_name.required' => __('Guard is required.'),
    'guard_name.in' => __('Invalid guard selected.'),
]);


        try {
            // find permission record
            $permission = Permission::findOrFail($id);

            // update permission values
            $permission->update([
                'name'       => $request->name,
                'guard_name' => $request->guard_name,
                'updated_by' => Auth::id(),
            ]);

            // success response
            return redirect()->back()->with('success', __('Permission has been successfully updated.'));

        } catch (QueryException $e) {
            // catch db error
            return redirect()->back()->with('error', __('Failed to update permission: ') . $e->getMessage());
        }
    }

    // toggle active or inactive status
    public function toggleStatus(Request $request)
    {
        // validate status request
        $request->validate([
            'id'     => 'required|exists:permissions,id',
            'status' => 'required|in:activate,deactivate',
        ]);

        $permission = Permission::findOrFail($request->id);

        $permission->update([
            'is_active'  => $request->status === "activate" ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        // respond to client (ajax)
        return response()->json([
            'success' => true,
            'message' => __('Permission status updated successfully.')
        ]);
    }
    
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete(); // soft delete (not permanent)

        return response()->json([
            'success' => true,
            'message' => __('Permission has been archived.')
        ]);
    }
}