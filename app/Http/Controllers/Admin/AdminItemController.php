<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminItemController extends Controller
{
    public function index()
    {
        $items = Item::with('owner')->get();
        return view('admin.items.index', compact('items'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'condition' => 'required'
        ]);

        Item::findOrFail($id)->update($request->all());

        return back()->with('success', 'Item berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return back()->with('success', 'Item berhasil dihapus!');
    }
}
