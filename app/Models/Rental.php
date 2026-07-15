<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'user_id',
        'customer_id',
        'gadget_id',
        'start_date',
        'end_date',
        'actual_return_date',
        'total_price',
        'fine_amount',
        'status',
        'total_amount',
        'payment_method',
        'payment_status',
        'delivery_option',
        'shipping_address',
        'voucher_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Gadget
    public function gadget()
    {
        return $this->belongsTo(Gadget::class);
    }

    // Relasi ke Voucher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
