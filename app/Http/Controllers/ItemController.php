<?php

namespace App\Http\Controllers;

use App\Models\Barangs as Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Semua barang (kecuali milik saya)
    public function index()
    {
        return Item::where('user_id', '!=', Auth::id())
            ->where('status', 'tersedia')
            ->get();
    }
    public function showItemsPage()
    {
        $items = Item::where('user_id', '!=', Auth::id())
                    ->where('status', 'tersedia')
                    ->get();

        return view('user.pinjam', compact('items'));
    }

    // Barang milik saya
    public function myItemsPage()
    {
        $barangs = Item::where('user_id', Auth::id())->get();

        return view('user.manajemen_barang', compact('barangs'));
    }


    // Tambahkan barang
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|image',
            'name' => 'required|string',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'pickup_address' => 'required|string',
            'qty' => 'required|integer|min:1',
            'condition' => 'required|string',
        ]);

        $path = $request->file('photo')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'photo' => $path,
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'pickup_address' => $request->pickup_address,
            'qty' => $request->qty,
            'condition' => $request->condition,
            'status' => 'tersedia',
        ]);

        return redirect()->route('items.mine.page')->with('success', 'Barang berhasil ditambahkan!');
    }

    // Detail barang
    public function show($id)
    {
        $barang = Item::with('user')->where('id', $id)->first();

        return view('barang.detail', ['barang' => $barang]);
    }


    // Update barang saya
    public function update(Request $request, $id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'string',
            'category' => 'string',
            'description' => 'string|nullable',
            'pickup_address' => 'string',
            'qty' => 'integer|min:1',
            'condition' => 'string',
            'status' => 'string',
            'photo' => 'image|nullable'
        ]);

        if ($request->hasFile('photo')) {
            $item->photo = $request->file('photo')->store('items', 'public');
        }

        $item->update($request->except('photo'));

        return response()->json(['message' => 'Item updated', 'item' => $item]);
    }

    // Hapus barang saya
    public function destroy($id)
    {
        $item = Item::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
