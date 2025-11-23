<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return Item::where('owner_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'nullable|string|max:255',
            'condition' => 'required|in:baru,baik,rusak ringan,rusak',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'owner_id' => auth()->id(),
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $path,
            'condition' => $request->condition,
        ]);

        return redirect()->route('dashboard')->with('success', 'Item berhasil ditambahkan!');
    }

    public function show($id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);

        $request->validate([
            'condition' => 'nullable|in:baru,baik,rusak ringan,rusak',
            'status' => 'nullable|in:available,borrowed,inactive',
        ]);

        $item->update($request->only([
            'name',
            'description',
            'condition',
            'status',
            'category_id'
        ]));

        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = Item::where('owner_id', auth()->id())->findOrFail($id);
        
        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
