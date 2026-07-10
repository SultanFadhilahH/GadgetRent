<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil query dasar beserta data relasi customer dan gadget
        $query = Rental::with(['customer', 'gadget']);

        // Filter berdasarkan status tab (Ongoing, Completed, Overdue) jika diklik
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $rentals = $query->latest()->get();
        $totalTransaksi = $rentals->count();

        return view('rentals.index', compact('rentals', 'totalTransaksi'));
    }
}
