<?php

namespace Modules\Organizational\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\Organizational\App\Models\CompanyCode;

class CompanyCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view company codes')->only(['index']);
        $this->middleware('permission:manage company codes')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyCodes = CompanyCode::with(['creator', 'updater'])
            ->orderBy('name')
            ->get();
        $companyCodes = CompanyCode::orderBy('id', 'desc')->get();
        return view('organizational::company-code', compact('companyCodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('company_codes', 'name'),
            ],
        ]);

        try {
            CompanyCode::create([
                'name'       => $request->name,
                'created_by' => Auth::id(),
                'is_active'  => 1,
            ]);

            return back()->with('success', __('Company Code successfully created.'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to create Company Code: ') . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('company_codes', 'name')->ignore($id),
            ],
        ]);

        try {
            $companyCode = CompanyCode::findOrFail($id);

            $companyCode->update([
                'name'       => $request->name,
                'updated_by' => Auth::id(),
            ]);

            return back()->with('success', __('Company Code successfully updated.'));
        } catch (\Exception $e) {
            return back()->with('error', __('Failed to update Company Code: ') . $e->getMessage());
        }
    }

    /**
     * Toggle active / inactive status.
     */
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:company_codes,id',
            'status' => 'required|in:activate,deactivate',
        ]);

        $companyCode = CompanyCode::findOrFail($request->id);

        $companyCode->update([
            'is_active'  => $request->status === 'activate' ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Company Code status updated successfully.'),
        ]);
    }

    /**
     * Remove the specified resource from storage (archive).
     */
    public function destroy($id)
    {
        $companyCode = CompanyCode::findOrFail($id);

        $companyCode->delete();

        return response()->json([
            'success' => true,
            'message' => __('Company Code has been archived.'),
        ]);
    }
}
