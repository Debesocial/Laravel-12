<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
public function index(Request $request)
{
    $logFile = storage_path('logs/laravel.log');

    if (!File::exists($logFile)) {
        $content = ["Log file tidak ditemukan."];
        return view('pages.superadmin.error-logs', compact('content'));
    }

    $logs = explode("\n", File::get($logFile));

    // FILTER TANGGAL - pattern log laravel: YYYY-MM-DD
    if ($request->filled('date')) {
        $date = $request->date;
        $logs = array_filter($logs, function ($line) use ($date) {
            return preg_match("/{$date}/", $line);
        });
    }

    // PAGINATION (100 baris)
    $logs = array_reverse($logs);
    $perPage = 100;
    $page = $request->input('page', 1);
    $offset = ($page - 1) * $perPage;
    $content = array_slice($logs, $offset, $perPage);

    return view('pages.superadmin.error-logs', compact('content'));
}


    public function download()
    {
        $logFile = storage_path('logs/laravel.log');

        if (!File::exists($logFile)) {
            return back()->with('error', 'Log file tidak ditemukan.');
        }

        return response()->download($logFile, 'laravel.log');
    }

    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');
        File::put($logFile, '');

        return back()->with('success', 'Log file berhasil dibersihkan.');
    }
}