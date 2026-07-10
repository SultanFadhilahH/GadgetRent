<?php

namespace App\Http\Controllers;

use App\Models\Gadget;
use App\Models\Category;
use Illuminate\Http\Request;

class GadgetController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Gadget::with('category');

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        $totalUnit = Gadget::count();
        $gadgets = $query->paginate(5)->appends($request->all());

        return view('gadgets.index', compact('gadgets', 'categories', 'totalUnit'));
    }

    // CREATE: Menyimpan data gadget baru
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:gadgets,serial_number',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
        ]);

        Gadget::create($request->all());

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil ditambahkan!');
    }

    // UPDATE: Menyimpan perubahan data gadget
    public function update(Request $request, Gadget $gadget)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:gadgets,serial_number,' . $gadget->id,
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
        ]);

        $gadget->update($request->all());

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil diperbarui!');
    }

    // DELETE: Menghapus data gadget
    public function destroy(Gadget $gadget)
    {
        $gadget->delete();

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil dihapus!');
    }
}
