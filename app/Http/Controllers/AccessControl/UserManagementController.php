<?php

namespace App\Http\Controllers\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserManagementController extends Controller
{

    /**
     * INDEX — Menampilkan daftar user & role (untuk dropdown)
     */
    public function index()
    {
        $users = User::with(['roles', 'creator', 'updater'])->get();
        $roles = Role::where('is_active', 1)
                    ->whereNull('deleted_at')
                    ->orderBy('name')
                    ->get();

        return view('pages.access_control.users', compact('users', 'roles'));
    }


    /**
     * STORE — Tambah user + assign role
     */
    public function store(Request $request)
    {
$request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/',
    ],
    'email' => [
        'required',
        'email',
        'max:150',
        Rule::unique('users', 'email'),
    ],
    'password' => [
        'required',
        'string',
        'min:12',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/',
    ],
    'roles' => [
        'required',
        'array',
        'min:1',
    ],
    'roles.*' => [
        'required',
        Rule::exists('roles', 'id'),
    ],
], [
    'name.regex' => __('Name may only contain letters and spaces.'),
    'email.unique' => __('This email is already registered.'),
    'password.regex' => __('Password must contain uppercase, lowercase, number, and symbol.'),
    'roles.required' => __('At least one role must be selected.'),
]);

        try {
            // create user
            $user = User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
                'is_active'  => 1,
                'created_by' => Auth::id(),
            ]);

        // 🔥 FIX: Convert role IDs → role names
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

        // assign roles by name
        $user->syncRoles($roleNames);

        return back()->with('success', __('User created successfully.'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to create user: ').$e->getMessage());
        }
    }


    /**
     * UPDATE — Edit user data + (optional) password + roles
     */
  public function update(Request $request, $id)
{
$request->validate([
    'name' => [
        'required',
        'string',
        'min:3',
        'max:100',
        'regex:/^[a-zA-Z\s]+$/',
    ],
    'email' => [
        'required',
        'email',
        'max:150',
        Rule::unique('users', 'email')->ignore($id),
    ],
    'password' => [
        'nullable',
        'string',
        'min:12',
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/',
    ],
    'roles' => [
        'required',
        'array',
        'min:1',
    ],
    'roles.*' => [
        Rule::exists('roles', 'id'),
    ],
], [
    'name.regex' => __('Name may only contain letters and spaces.'),
    'password.regex' => __('Password must contain uppercase, lowercase, number, and symbol.'),
]);

    try {
        $user = User::findOrFail($id);

        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'updated_by' => Auth::id(),
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // 🔥 FIX: Convert ID role → Role Name
        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        $user->syncRoles($roleNames);

        return back()->with('success', __('User updated successfully.'));

    } catch (\Exception $e) {
        return back()->with('error', __('Failed to update user: ') . $e->getMessage());
    }
}



    /**
     * TOGGLE — Aktivasi/Non-aktifkan user
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:users,id',
            'status' => 'required|in:activate,deactivate',
        ]);

        $user = User::findOrFail($request->id);

        $user->update([
            'is_active'  => $request->status === "activate" ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('User status updated successfully.')
        ]);
    }


    /**
     * DESTROY — Archive (Soft Delete)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => __('User has been archived.')
        ]);
    }
}