<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Barangs as Barang;
use App\Models\Loan as Peminjaman;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_barangs' => Barang::count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_pending' => Peminjaman::where('status', 'pending')->count(),
        ];

        // Data peminjaman yang menunggu persetujuan (pending)
        $peminjamans = Peminjaman::with(['user', 'barang'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10); // gunakan pagination sesuai view

        return view('admin.dashboard', compact('stats', 'peminjamans'));    
    }
}
