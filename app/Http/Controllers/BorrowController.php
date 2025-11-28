<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function requestBorrow($id)
    {
        $item = Item::findOrFail($id);

        if ($item->status !== 'Tersedia') {
            return back()->with('error', 'Barang tidak tersedia.');
        }

        // Contoh saja, nanti bisa dibuat table borrow_requests
        $item->status = 'Dipinjam';
        $item->save();

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim!');
    }
}
