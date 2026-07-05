<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'actual_return_date' => 'date',
        ];
    }

    /**
     * Get the user (staff) that handled this rental.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer for this rental.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the gadget for this rental.
     */
    public function gadget(): BelongsTo
    {
        return $this->belongsTo(Gadget::class);
    }
}
