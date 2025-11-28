<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // ← tambah import

class NotificationController extends Controller
{
    /**
     * Menampilkan daftar notifikasi pengguna.
     */
    public function index()
    {
        // fallback kalau tabel belum ada
        if (! Schema::hasTable('notifications')) {
            $notifications = collect(); // kosong — hindari query error
            return view('user.notifikasi', compact('notifications'));
        }

        $notifications = auth()->check()
            ? auth()->user()->notifications()->latest()->get()
            : DB::table('notifications')->orderByDesc('created_at')->get();

        return view('user.notifikasi', compact('notifications'));
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca.
     */
    public function markRead($id)
    {
        if (! auth()->check()) return back();
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return back();
    }
}