<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActionLogController extends Controller
{
    public function index(Request $request)
    {
        // ambil semua input filter
        $user       = $request->user;
        $action     = $request->action;
        $keyword    = $request->keyword;
        $module     = $request->module;
        $ip         = $request->ip_address;
        $agent      = $request->agent;
        $date       = $request->date;

        // sort by date (asc / desc) -> default desc (terbaru dulu)
        $sort = $request->sort ?? 'desc';

        // query dasar
        $query = Activity::query()->orderBy('created_at', $sort);

        // filtering by user email
        if ($user) {
            $query->whereHas('causer', function ($q) use ($user) {
                $q->where('email', 'like', "%{$user}%");
            });
        }

        // filtering action (description)
        if ($action) {
            $query->where('description', 'like', "%{$action}%");
        }

        // keyword pada kolom detail
        if ($keyword) {
            $query->where('properties->details', 'like', "%{$keyword}%");
        }

        // filter module
        if ($module) {
            $query->where('log_name', 'like', "%{$module}%");
        }

        // filter IP Address
        if ($ip) {
            $query->where('properties->ip', 'like', "%{$ip}%");
        }

        // filter agent
        if ($agent) {
            $query->where('properties->agent', 'like', "%{$agent}%");
        }

        // filter tanggal (format YYYY-MM-DD)
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // load hasil
        $actionlogs = $query->paginate(50)->withQueryString();

        // kirim ke view
        return view('pages.superadmin.action-logs', compact('actionlogs'));
    }
}