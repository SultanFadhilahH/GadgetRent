<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Gadget;
use App\Models\User;
use App\Support\PermissionLabel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========================================
        // 1. Pembuatan Hak Akses (Permissions)
        // ========================================
        $adminPermissionNames = [
            'manage-categories-gadgets',
            'manage-rentals',
            'manage-returns-fines',
            'manage-users-roles',
            'full-reports-access',
        ];

        $staffPermissionNames = [
            'create-manage-transactions',
            'view-gadget-status',
            'process-returns-fines',
            'manage-customer-data',
        ];

        foreach (array_keys(PermissionLabel::MAP) as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // ========================================
        // 2. Pembuatan Role Spatie
        // ========================================
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->syncPermissions($adminPermissionNames);

        $staffRole = Role::create(['name' => 'Staff']);
        $staffRole->syncPermissions($staffPermissionNames);

        // ========================================
        // 3. Akun Admin
        // ========================================
        $admin = User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        // ========================================
        // 4. Akun Staff
        // ========================================
        $staff = User::create([
            'name' => 'Staff Kasir',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('Staff');

        // ========================================
        // 5. Akun Pengguna Tanpa Peran (contoh)
        // ========================================
        User::create([
            'name' => 'sultan',
            'email' => 'sultan123@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // ========================================
        // 6. Data Dummy Category (3 Kategori)
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
        // 7. Data Dummy Gadget (5 Gadget Realistis)
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
        // 8. Data Dummy Customer (2 Pelanggan)
        // ========================================
        Customer::create([
            'name' => 'Daren Safana Darmawan',
            'nik' => '3201234567890001',
            'phone_number' => '081234567890',
            'address' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        Customer::create([
            'name' => 'Darel Safana Darmawan',
            'nik' => '3201234567890002',
            'phone_number' => '082345678901',
            'address' => 'Jl. Asia Afrika No. 25, Bandung',
        ]);

        // ========================================
        // 7. Panggil RentalSeeder yang baru dibuat
        // ========================================
        $this->call([
            RentalSeeder::class,
        ]);
    }
}