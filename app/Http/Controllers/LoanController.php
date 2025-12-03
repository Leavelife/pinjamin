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
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Buat pinjaman
        $loan = Loan::create([
            'user_id' => Auth::id(),       // peminjam
            'barang_id' => $barangId,      // barang
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'diajukan',
        ]);

        // Buat notifikasi untuk pemilik barang
        Notification::create([
            'user_id' => $barang->user_id,
            'type' => 'pengajuan_peminjaman',
            'title' => 'Pengajuan Peminjaman Baru',
            'message' => "Pengajuan pinjaman baru untuk barang: " . $barang->name,
        ]);

        return back()->with('success', 'Pengajuan pinjaman dikirim.');
    }

    // ============================
    // RIWAYAT PINJAMAN SAYA
    // ============================
    // --- LoanController.php ---
    public function historyPage()
    {
        $user = Auth::user();

        $loans = Loan::with(['user', 'barang', 'barang.user'])
            ->where('user_id', $user->id) 
            ->orWhereHas('barang', function($q) use ($user) {
                $q->where('user_id', $user->id); 
            })
            ->latest()
            ->get();

        // Pastikan semua data yang dibutuhkan di Blade ada di sini
        $formatted = $loans->map(function ($loan) {

            return [
                // Kunci yang dibutuhkan untuk logika dan tampilan:
                'id' => $loan->id, // ID Pinjaman untuk route Approve/Reject
                'user_name' => $loan->user->name ?? 'N/A', // Nama Peminjam
                'barang_name' => $loan->barang->name ?? 'N/A', // Nama Barang
                'qty' => 1, // Asumsi Qty
                'tanggal_pinjam' => $loan->tanggal_pinjam, // Objek Carbon untuk format
                'status' => $loan->status, 
                'owner_id' => $loan->barang->user_id, // ID pemilik barang
                
                // Kunci yang sudah ada sebelumnya
                'title' => $loan->barang->name ?? 'Tidak diketahui',
                'subtitle' => 'Kode Barang #' . $loan->barang_id,
                'url' => route('items.show.page', $loan->barang_id),
                'date' => \Carbon\Carbon::parse($loan->created_at),
                'type' => $loan->status, 
                'meta' => [
                    'gambar' => $loan->barang->photo
                        ? asset('storage/' . $loan->barang->photo)
                        : '/images/default.png'
                ],

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
        $loan = Loan::findOrFail($id);

        if ($loan->barang->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $loan->status = 'dipinjam';
        $loan->save();

        // Buat notifikasi ke peminjam
        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Peminjaman Disetujui',
            'message' => "Pengajuan peminjaman {$loan->barang->name} telah disetujui",
            'related_id' => $loan->id,
            'related_type' => 'loan',
        ]);

        return back()->with('success', 'Peminjaman disetujui!');
    }

    // Tolak peminjaman (hanya pemilik barang)
    public function reject($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->barang->user_id != auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $loan->status = 'ditolak';
        $loan->save();

        // Buat notifikasi ke peminjam
        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Peminjaman Ditolak',
            'message' => "Pengajuan peminjaman {$loan->barang->name} ditolak",
            'related_id' => $loan->id,
            'related_type' => 'loan',
        ]);

        return back()->with('success', 'Peminjaman ditolak!');
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
