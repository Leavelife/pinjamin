<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Asumsi nama Model Anda adalah Barang

class BarangController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan nilai filter dari request
        $q = $request->input('q');      // Pencarian teks
        $jenis = $request->input('jenis');  // Filter Jenis Barang
        $status = $request->input('status'); // Filter Status

        // 1. Buat Query Dasar
        $barangsQuery = Barang::query();

        // 2. Terapkan Pencarian Teks (q)
        if ($q) {
            $barangsQuery->where(function ($query) use ($q) {
                $query->where('nama', 'LIKE', '%' . $q . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . $q . '%');
            });
        }

        // 3. Terapkan Filter Jenis Barang
        if ($jenis) {
            $barangsQuery->where('jenis', $jenis);
        }

        // 4. Terapkan Filter Status
        if ($status) {
            $barangsQuery->where('status', $status);
        }
        
        // --- DATA UNTUK VIEW ---
        
        // Ambil data barang (dengan paginasi 12 item per halaman)
        $barangs = $barangsQuery->paginate(12)->withQueryString();

        // Data list untuk tombol filter (Anda perlu mendefinisikannya)
        $jenisList = ['Buku', 'Alat', 'Pakaian', 'Elektronik']; 
        $statusList = ['Tersedia', 'Dipinjam', 'Tidak tersedia'];

        // Kirim semua data ke View
        return view('items.index', compact('barangs', 'q', 'jenis', 'status', 'jenisList', 'statusList'));
    }
}