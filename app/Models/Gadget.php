<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gadget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'brand',
        'serial_number',
        'price_per_day',
        'status',
        'image',
    ];

    // Hubungkan relasi ke tabel categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
