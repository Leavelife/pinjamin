<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman; 
use App\Models\Barang; // Asumsi Anda butuh model Barang
use App\Notifications\NewPeminjaman; // Wajib di-import

class PeminjamanController extends Controller
{
    // ... method lain (index, create, show)

    /**
     * Menyimpan permintaan peminjaman baru ke database dan mengirim notifikasi.
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah' => 'required|integer|min:1',
            // ... validasi lain
        ]);
        
        // Tambahkan user_id dari user yang sedang login
        $validatedData['user_id'] = Auth::id();

        // 2. Buat model Peminjaman yang baru saja dibuat
        //    RELASI: Peminjaman (user_id) -> Barang (barang_id)
        $peminjaman = Peminjaman::create($validatedData);

        // 3. Tentukan siapa yang akan menerima notifikasi (Pemilik Barang)
        //    Kami menggunakan relasi 'barang' pada model Peminjaman untuk mengakses pemiliknya.
        //    Asumsi: Peminjaman model punya relasi 'barang', dan Barang model punya relasi 'user' (pemilik).
        $barang = $peminjaman->barang;
        $owner = $barang->user;

        // 4. Kirim notifikasi HANYA jika pemilik barang ditemukan
        if ($owner) {
            $owner->notify(new NewPeminjaman($peminjaman));
            // Tambahkan logging untuk debugging jika notifikasi tidak muncul
            // \Log::info('Notifikasi Peminjaman baru dikirim ke User ID: ' . $owner->id);
        }

        // 5. Redirect atau respons
        return redirect()->route('peminjaman.history')->with('success', 'Permintaan peminjaman berhasil diajukan. Pemilik barang telah diberi notifikasi.');
    }
    
    // ... method lain (edit, update, destroy)
}