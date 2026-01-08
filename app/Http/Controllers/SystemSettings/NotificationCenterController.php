<?php

namespace App\Http\Controllers\SystemSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class NotificationCenterController extends Controller
{
    /**
     * =====================================================
     * INDEX
     * Tampilkan halaman notification center
     * =====================================================
     */
    public function index()
    {
        $notifications = Notification::orderByDesc('created_at')->get();

        return view('pages.system_settings.notification-center', compact('notifications'));
    }

    /**
     * =====================================================
     * STORE
     * Simpan notifikasi baru
     * =====================================================
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'message'   => 'required|string',
            'recipient' => 'required|in:all,admin,user',
            'type'      => 'required|in:info,warning,system',
        ]);

        Notification::create([
            ...$validated,
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('notification-center.index')
            ->with('success', __('Notification sent successfully.'));
    }

    /**
     * =====================================================
     * MARK AS READ
     * =====================================================
     */
    public function markAsRead(Notification $notification)
    {
        if (!$notification->read_at) {
            $notification->update([
                'read_at' => now(),
            ]);
        }

        return back();
    }

    /**
     * =====================================================
     * DELETE
     * =====================================================
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with('success', __('Notification deleted.'));
    }
}