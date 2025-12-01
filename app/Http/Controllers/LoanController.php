<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Notification;
use App\Models\Barangs as Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // ============================
    // AJUKAN PINJAMAN
    // ============================
    public function requestLoan(Request $request, $barangId)
    {
        $barang = Item::findOrFail($barangId);

        // Tidak boleh meminjam barang sendiri
        if ($barang->user_id == Auth::id()) {
            return back()->with('error', 'Tidak boleh meminjam barang sendiri.');
        }

        // Validasi tanggal pinjam saja
        $request->validate([
            'tanggal_pinjam' => 'required|date',
        ]);

        // Buat pinjaman
        $loan = Loan::create([
            'user_id' => Auth::id(),       // peminjam
            'barang_id' => $barangId,      // barang
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'diajukan',
        ]);

        // Buat notifikasi untuk pemilik barang
        Notification::create([
            'user_id' => $barang->user_id,
            'type' => 'loan_request',
            'message' => "Pengajuan pinjaman baru untuk barang: " . $barang->name,
        ]);

        return back()->with('success', 'Pengajuan pinjaman dikirim.');
    }

    // ============================
    // RIWAYAT PINJAMAN SAYA
    // ============================
    public function historyPage()
    {
        $loans = Loan::with(['barang', 'user']) // barang = item yang dipinjam; user = peminjam
            ->where('user_id', Auth::id())     // berdasarkan siapa yang meminjam
            ->orderBy('created_at', 'desc')
            ->get();

        // Format card seperti struktur lama $it[]
        $formatted = $loans->map(function ($loan) {

            return [
                'title' => $loan->barang->name ?? 'Tidak diketahui',
                'subtitle' => 'Kode Barang #' . $loan->barang_id,
                'url' => route('items.show.page', $loan->barang_id),

                // Format tanggal
                'date' => \Carbon\Carbon::parse($loan->created_at),

                // Jenis aktivitas
                'type' => $loan->status, // diajukan / dipinjam / dikembalikan

                // Akses ke status untuk badge
                'status' => $loan->status,

                // Meta untuk gambar
                'meta' => [
                    'gambar' => $loan->barang->photo
                        ? asset('storage/' . $loan->barang->photo)
                        : '/images/default.png'
                ]
            ];
        });

        return view('user.history', [
            'loans' => $formatted
        ]);
    }


    // ============================
    // DETAIL PINJAMAN
    // ============================
    public function detail($id)
    {
        return Loan::with(['barang', 'barang.user'])
            ->where(function ($q) {
                $q->where('user_id', Auth::id())   // saya peminjam
                  ->orWhereHas('barang', function ($b) {
                      $b->where('user_id', Auth::id()); // saya pemilik barang
                  });
            })
            ->findOrFail($id);
    }

    // ============================
    // APPROVE PEMINJAMAN (Owner)
    // ============================
    public function approve($id)
    {
        $loan = Loan::with('barang')->findOrFail($id);

        if ($loan->barang->user_id !== Auth::id()) {
            return back()->with('error', 'Tidak punya akses.');
        }

        $loan->update([
            'status' => 'dipinjam',
        ]);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    // ============================
    // USER MENGAJUKAN PENGEMBALIAN
    // ============================
    public function requestReturn(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        $loan->update([
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        return back()->with('success', 'Permintaan pengembalian dikirim.');
    }

    // ============================
    // OWNER MENGKONFIRMASI PENGEMBALIAN
    // ============================
    public function confirmReturn($id)
    {
        $loan = Loan::with('barang')->findOrFail($id);

        if ($loan->barang->user_id !== Auth::id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $loan->update([
            'tanggal_dikembalikan' => now(),
            'status' => 'dikembalikan',
        ]);

        return back()->with('success', 'Barang telah dikembalikan.');
    }
}
