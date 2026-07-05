<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nik',
        'phone_number',
        'address',
    ];

    /**
     * Get the rentals for this customer.
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }
}
