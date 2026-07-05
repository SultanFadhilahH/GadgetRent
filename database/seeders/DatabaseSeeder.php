<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Gadget;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========================================
        // 1. Pembuatan Role Spatie
        // ========================================
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);

        // ========================================
        // 2. Akun Admin
        // ========================================
        $admin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // ========================================
        // 3. Akun Staff
        // ========================================
        $staff = User::create([
            'name' => 'Staff Kasir',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('Staff');

        // ========================================
        // 4. Data Dummy Category (3 Kategori)
        // ========================================
        $kamera = Category::create([
            'name' => 'Kamera',
            'description' => 'Peralatan kamera digital dan mirrorless untuk fotografi dan videografi profesional.',
        ]);

        $laptop = Category::create([
            'name' => 'Laptop',
            'description' => 'Laptop untuk kebutuhan kerja, desain grafis, dan programming.',
        ]);

        $konsol = Category::create([
            'name' => 'Konsol Game',
            'description' => 'Konsol gaming terbaru untuk hiburan dan streaming.',
        ]);

        // ========================================
        // 5. Data Dummy Gadget (5 Gadget Realistis)
        // ========================================
        Gadget::create([
            'category_id' => $kamera->id,
            'name' => 'Sony A7 III',
            'brand' => 'Sony',
            'serial_number' => 'SNY-A7III-20260001',
            'price_per_day' => 350000,
            'status' => 'available',
        ]);

        Gadget::create([
            'category_id' => $kamera->id,
            'name' => 'Canon EOS R6 Mark II',
            'brand' => 'Canon',
            'serial_number' => 'CAN-R6MK2-20260002',
            'price_per_day' => 400000,
            'status' => 'available',
        ]);

        Gadget::create([
            'category_id' => $laptop->id,
            'name' => 'MacBook Air M2',
            'brand' => 'Apple',
            'serial_number' => 'APL-MBA-M2-20260003',
            'price_per_day' => 250000,
            'status' => 'available',
        ]);

        Gadget::create([
            'category_id' => $konsol->id,
            'name' => 'PlayStation 5',
            'brand' => 'Sony',
            'serial_number' => 'SNY-PS5-20260004',
            'price_per_day' => 150000,
            'status' => 'available',
        ]);

        Gadget::create([
            'category_id' => $konsol->id,
            'name' => 'Nintendo Switch OLED',
            'brand' => 'Nintendo',
            'serial_number' => 'NTD-SWOLED-20260005',
            'price_per_day' => 100000,
            'status' => 'available',
        ]);

        // ========================================
        // 6. Data Dummy Customer (2 Pelanggan)
        // ========================================
        Customer::create([
            'name' => 'Budi Santoso',
            'nik' => '3201234567890001',
            'phone_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        Customer::create([
            'name' => 'Siti Rahayu',
            'nik' => '3201234567890002',
            'phone_number' => '082345678901',
            'address' => 'Jl. Asia Afrika No. 25, Bandung',
        ]);
    }
}
