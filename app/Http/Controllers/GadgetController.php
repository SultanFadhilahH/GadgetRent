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
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:gadgets,serial_number',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        Gadget::create($validated);

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil ditambahkan!');
    }

    // UPDATE: Menyimpan perubahan data gadget
    public function update(Request $request, Gadget $gadget)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:gadgets,serial_number,' . $gadget->id,
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($gadget->image);
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        $gadget->update($validated);

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil diperbarui!');
    }

    // DELETE: Menghapus data gadget
    public function destroy(Gadget $gadget)
    {
        $this->deleteImage($gadget->image);
        $gadget->delete();

        return redirect()->route('admin.gadgets.index')->with('success', 'Gadget berhasil dihapus!');
    }

    private function storeImage($file): string
    {
        $filename = uniqid('gadget_').'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/gadgets'), $filename);

        return $filename;
    }

    private function deleteImage(?string $filename): void
    {
        if ($filename && file_exists(public_path('images/gadgets/'.$filename))) {
            unlink(public_path('images/gadgets/'.$filename));
        }
    }
}
