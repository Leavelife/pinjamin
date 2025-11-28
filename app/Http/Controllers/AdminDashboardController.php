<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_barangs' => Barang::count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
        ];

        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        $users_irresponsible = User::where('role', 'user')
            ->withCount('peminjamans')
            ->having('peminjamans_count', '>', 3)
            ->get();

        return view('admin.dashboard', compact('stats', 'peminjamans', 'users_irresponsible'));
    }

    public function approvePeminjaman($id)
    {
        $peminjaman = Peminjaman::find($id);
        $peminjaman->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Peminjaman disetujui!');
    }

    public function rejectPeminjaman($id)
    {
        $peminjaman = Peminjaman::find($id);
        $peminjaman->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Peminjaman ditolak!');
    }

    public function blockUser($id)
    {
        $user = User::find($id);
        $user->update(['is_blocked' => true]);

        return redirect()->back()->with('success', 'User diblokir!');
    }

    public function unblockUser($id)
    {
        $user = User::find($id);
        $user->update(['is_blocked' => false]);

        return redirect()->back()->with('success', 'User dibuka blokir!');
    }

    public function userActivity($id)
    {
        $user = User::with('peminjamans')->find($id);
        $peminjamans = $user->peminjamans()->latest()->paginate(15);

        return view('admin.user-activity', compact('user', 'peminjamans'));
    }
}