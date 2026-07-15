<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();
        
        $activeCount = Voucher::where('is_active', true)->where('end_date', '>=', now())->count();
        $expiredCount = Voucher::where('end_date', '<', now())->count();
        $totalUsage = Voucher::sum('usage_count');

        return view('admin.vouchers.index', compact('vouchers', 'activeCount', 'expiredCount', 'totalUsage'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code|max:255',
            'discount_type' => 'required|in:percent,nominal',
            'discount_value' => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = true;
        
        Voucher::create($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:vouchers,code,'.$voucher->id.'|max:255',
            'discount_type' => 'required|in:percent,nominal',
            'discount_value' => 'required|numeric|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['code'] = strtoupper($validated['code']);
        $validated['is_active'] = $request->boolean('is_active');

        $voucher->update($validated);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher berhasil dihapus!');
    }
}
