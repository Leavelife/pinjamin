<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    // 1. Tampilkan semua notifikasi user
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    // 2. Tandai notifikasi sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->read_at = Carbon::now();
        $notification->save();

        // Jika via AJAX bisa return JSON
        return response()->json([
            'status' => 'success',
            'message' => 'Notification marked as read'
        ]);
    }

    // 3. Tampilkan detail notifikasi atau redirect ke related item
    public function show($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Tandai sebagai dibaca
        if (!$notification->read_at) {
            $notification->read_at = Carbon::now();
            $notification->save();
        }

        // Redirect ke halaman terkait jika ada
        if ($notification->related_type && $notification->related_id) {
            $relatedRoute = $this->getRelatedRoute($notification->related_type, $notification->related_id);
            if ($relatedRoute) {
                return redirect($relatedRoute);
            }
        }

        // Kalau tidak ada related, tampilkan halaman detail notifikasi
        return view('user.notification', compact('notification'));
    }

    // Helper: menentukan route terkait berdasarkan type
    private function getRelatedRoute($type, $id)
    {
        switch ($type) {
            case 'item':
                return route('items.show', $id);
            case 'order':
                return route('orders.show', $id);
            default:
                return null;
        }
    }
}
