<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    // ... (Fungsi show dan ajukanPeminjaman yang sudah ada) ...

    /**
     * Menampilkan form untuk menambahkan barang baru (Tampilan 'Tawarkan barang').
     */
    public function create()
    {
        // Variabel ini HARUS dikirimkan ke view untuk mengisi dropdown Kategori.
        $kategoris = [
            'Elektronik', 
            'Buku', 
            'Peralatan Olahraga', 
            'Jasa', 
            'Lain-lain'
        ];

        // Memanggil view 'barang.create' dan mengirimkan variabel $kategoris.
        return view('barang.create', compact('kategoris'));
    }

    /**
     * Menyimpan data barang baru dari form ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:png,jpg,jpeg|max:5120',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        // 1. Upload Gambar
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            // Simpan gambar di folder public/barangs
            $gambarPath = $request->file('gambar')->store('public/barangs');
            $gambarPath = Storage::url($gambarPath); 
        }

        // 2. Simpan ke Database
        Barang::create([
            'owner_id' => Auth::id(), 
            'nama' => $request->nama,
            'jenis' => $request->kategori, 
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'gambar' => $gambarPath,
            'status' => 'Tersedia', 
        ]);
        
        // Redirect ke dashboard dengan notifikasi sukses
        return redirect()->route('dashboard')->with('success', 'Barang berhasil ditawarkan!');
    }

    public function manajemen()
{
    $barangs = Barang::all();
    return view('user.manajemen_barang', compact('barangs'));
}
}