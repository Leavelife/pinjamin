<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class ItemController extends Controller
{
    //ambil item/barang sesuai pemilik
    public function index()
    {
        return Item::where('owner_id', auth()->id())->get();
    }
    public function create()
    {
        $categories = Category::all();
        return view('items-form', compact('categories'));
    }
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu!');
        }
        $request->validate([
            'name' => 'required',
            'category' => 'nullable|string|max:255',
            'condition' => 'required|in:baru,baik,rusak ringan,rusak',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        try {
            $item = Item::create([
                'owner_id' => auth()->id(),
                'name' => $request->name,
                'category' => $request->category,
                'description' => $request->description ?? '',
                'image' => $path,
                'condition' => $request->condition,
            ]);

            return redirect()->route('dashboard')->with('success', 'Item berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Item creation error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan item: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);

        return response()->json($item);
    }

    public function edit($id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);
        $categories = Category::all();
        
        return view('items-edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category' => 'nullable|string|max:255',
            'condition' => 'required|in:baru,baik,rusak ringan,rusak',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updateData = [
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description ?? '',
            'condition' => $request->condition,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $updateData['image'] = $path;
        }

        $item->update($updateData);

        return redirect()->route('dashboard')->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);
        
        // Delete image if exists
        if ($item->image) {
            \Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->route('dashboard')->with('success', 'Item berhasil dihapus!');
    }
}
