<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequest as Borrow;
use Illuminate\Http\Request;

class AdminBorrowController extends Controller
{
    public function index()
    {
        $borrows = Borrow::with(['item', 'borrower'])->get();
        return view('admin.borrow.index', compact('borrows'));
    }

    public function update(Request $request, $id)
    {
        $borrow = Borrow::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,borrowed,returned'
        ]);

        $borrow->update(['status' => $request->status]);

        return back()->with('success', 'Status peminjaman diperbarui!');
    }

    public function destroy($id)
    {
        Borrow::findOrFail($id)->delete();
        return back()->with('success', 'Data peminjaman dihapus!');
    }
}
