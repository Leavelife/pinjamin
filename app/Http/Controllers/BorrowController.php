<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\BorrowRequest;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    // Halaman list barang untuk dipinjam
    public function index()
    {
        // Tampilkan barang yang available dan bukan milik user
        $items = Item::where('status', 'available')
                    ->where('owner_id', '!=', auth()->id())
                    ->paginate(12);

        return view('borrow.index', ['items' => $items]);
    }

    // Detail barang dan form peminjaman
    public function create($id)
    {
        $item = Item::findOrFail($id);

        // Cek apakah barang milik user sendiri
        if ($item->owner_id === auth()->id()) {
            return redirect()->route('borrow.index')->with('error', 'Anda tidak bisa meminjam barang milik sendiri!');
        }

        return view('borrow.create', ['item' => $item]);
    }

    // Simpan permintaan peminjaman
    public function store(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if ($item->owner_id === auth()->id()) {
            return redirect()->route('borrow.index')->with('error', 'Anda tidak bisa meminjam barang milik sendiri!');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'message' => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah ada permintaan pending/approved untuk barang ini
        $existingRequest = BorrowRequest::where('item_id', $id)
                                       ->whereIn('status', ['pending', 'approved', 'borrowed'])
                                       ->first();

        if ($existingRequest) {
            return redirect()->back()->withErrors(['error' => 'Barang ini sedang dalam proses peminjaman atau telah dipinjam.']);
        }

        BorrowRequest::create([
            'item_id' => $id,
            'borrower_id' => auth()->id(),
            'owner_id' => $item->owner_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('borrow.status')->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }

    // Halaman status peminjaman saya
    public function status()
    {
        $borrowRequests = BorrowRequest::forBorrower(auth()->id())
                                       ->with('item', 'owner')
                                       ->latest()
                                       ->paginate(10);

        return view('borrow.status', ['requests' => $borrowRequests]);
    }

    // Halaman permintaan peminjaman untuk barang saya (sebagai pemilik)
    public function requests()
    {
        $pendingRequests = BorrowRequest::forOwner(auth()->id())
                                        ->with('item', 'borrower')
                                        ->pending()
                                        ->latest()
                                        ->paginate(10);

        return view('borrow.requests', ['requests' => $pendingRequests]);
    }

    // Approve permintaan peminjaman
    public function approve($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        // Cek apakah user adalah owner
        if ($borrowRequest->owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak mengubah permintaan ini!');
        }

        $borrowRequest->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Permintaan peminjaman disetujui!');
    }

    // Reject permintaan peminjaman
    public function reject($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        // Cek apakah user adalah owner
        if ($borrowRequest->owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak mengubah permintaan ini!');
        }

        $borrowRequest->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Permintaan peminjaman ditolak!');
    }

    // Mark sebagai borrowed (dimulai peminjaman)
    public function markBorrowed($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        // Cek apakah user adalah owner
        if ($borrowRequest->owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak mengubah status ini!');
        }

        if ($borrowRequest->status !== 'approved') {
            return redirect()->back()->with('error', 'Hanya permintaan yang disetujui yang bisa ditandai sebagai dipinjam!');
        }

        $borrowRequest->update(['status' => 'borrowed']);
        $borrowRequest->item->update(['status' => 'borrowed']);

        return redirect()->back()->with('success', 'Peminjaman dimulai!');
    }

    // Mark sebagai returned (barang dikembalikan)
    public function markReturned($id)
    {
        $borrowRequest = BorrowRequest::findOrFail($id);

        // Cek apakah user adalah owner
        if ($borrowRequest->owner_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki hak mengubah status ini!');
        }

        if ($borrowRequest->status !== 'borrowed') {
            return redirect()->back()->with('error', 'Hanya barang yang sedang dipinjam yang bisa dikembalikan!');
        }

        $borrowRequest->update([
            'status' => 'returned',
            'actual_return_date' => now()->toDateString(),
        ]);

        $borrowRequest->item->update(['status' => 'available']);

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan!');
    }
}
