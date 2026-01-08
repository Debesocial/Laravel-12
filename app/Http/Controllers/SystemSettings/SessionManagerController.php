<?php

namespace App\Http\Controllers\SystemSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionManagerController extends Controller
{
    public function index(Request $request)
    {
        $sessions = DB::table('sessions')
            ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
            ->select(
                'sessions.*',
                'users.email as user_email'
            )
            ->when($request->user, function ($q) use ($request) {
                $q->where('users.email', 'like', '%'.$request->user.'%');
            })
            ->when($request->ip_address, function ($q) use ($request) {
                $q->where('sessions.ip_address', 'like', '%'.$request->ip_address.'%');
            })
            ->when($request->agent, function ($q) use ($request) {
                $q->where('sessions.user_agent', 'like', '%'.$request->agent.'%');
            })
            ->orderByDesc('sessions.last_activity')
            ->get();

        return view('pages.system_settings.session-manager', compact('sessions'));
    }

    public function destroy($id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        return back()->with('success', __('Session terminated successfully.'));
    }
}