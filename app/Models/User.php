<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'username', 'nik', 'phone', 'birth_date', 'gender', 'ktp_image_path', 'ktp_verified_at', 'province', 'city', 'district', 'postal_code', 'address_detail'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the rentals handled by this user (staff).
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the carts belonging to this user (customer).
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the full address as a single string.
     */
    public function getFullAddressAttribute(): ?string
    {
        if (!$this->address_detail) return null;
        $parts = array_filter([
            $this->address_detail,
            $this->district,
            $this->city,
            $this->province,
            $this->postal_code,
        ]);
        return implode(', ', $parts);
    }

    /**
     * Check if the user has a complete address.
     */
    public function hasAddress(): bool
    {
        return !empty($this->address_detail) && !empty($this->city) && !empty($this->province);
    }
}
