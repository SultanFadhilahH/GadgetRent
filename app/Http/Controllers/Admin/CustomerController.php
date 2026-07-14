<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('rentals')->with(['rentals' => function ($q) {
            $q->with('gadget')->latest('start_date');
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $totalCustomer = Customer::count();
        $customers = $query->latest()->paginate(10)->appends($request->all());

        return view('admin.customers.index', compact('customers', 'totalCustomer'));
    }
}
