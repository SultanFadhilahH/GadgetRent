<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil query dasar beserta data relasi customer dan gadget
        $query = Rental::with(['customer', 'gadget', 'user']);

        // Filter berdasarkan status tab (Ongoing, Completed, Overdue) jika diklik
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('customer', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('gadget', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $totalTransaksi = Rental::count();
        $rentals = $query->latest()->paginate(5)->appends($request->all());

        return view('rentals.index', compact('rentals', 'totalTransaksi'));
    }
}
