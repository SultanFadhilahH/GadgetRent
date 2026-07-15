<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReturnController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with(['customer', 'gadget', 'user'])->whereIn('status', ['ongoing', 'overdue']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('user', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('gadget', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $totalAktif = Rental::whereIn('status', ['ongoing', 'overdue'])->count();
        $rentals = $query->latest('end_date')->paginate(10)->appends($request->all());

        return view('admin.returns.index', compact('rentals', 'totalAktif'));
    }

    public function process(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'actual_return_date' => ['required', 'date', 'after_or_equal:'.$rental->start_date],
        ]);

        $endDate = Carbon::parse($rental->end_date)->startOfDay();
        $returnDate = Carbon::parse($validated['actual_return_date'])->startOfDay();
        $lateDays = $returnDate->greaterThan($endDate) ? $endDate->diffInDays($returnDate) : 0;
        $fineAmount = $lateDays * $rental->gadget->price_per_day;

        $rental->update([
            'actual_return_date' => $returnDate,
            'fine_amount' => $fineAmount,
            'status' => 'completed',
        ]);

        $rental->gadget()->update(['status' => 'available']);

        return back()->with('success', $fineAmount > 0
            ? "Pengembalian diproses. Denda keterlambatan: Rp ".number_format($fineAmount, 0, ',', '.').'.'
            : 'Pengembalian diproses. Tidak ada denda.');
    }
}
