<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gadget;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Gadget::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        $totalUnit = Gadget::count();
        $gadgets = $query->latest()->paginate(9)->appends($request->all());

        return view('customer.catalog', compact('gadgets', 'categories', 'totalUnit'));
    }

    public function show(Gadget $gadget)
    {
        $gadget->load('category');

        return view('customer.catalog-show', compact('gadget'));
    }
}
