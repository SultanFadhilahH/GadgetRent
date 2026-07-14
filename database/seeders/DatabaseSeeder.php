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
            'image' => $this->seedGadgetImage('Sony A7 III'),
            'brand' => 'Sony',
            'serial_number' => 'SNY-A7III-20260001',
            'price_per_day' => 350000,
            'status' => 'available',
            'description' => 'Kamera mirrorless full-frame andalan untuk foto dan video dengan performa low-light yang kuat serta autofokus cepat, cocok untuk konten kreator dan fotografer event.',
            'specs' => ['Sensor full-frame 24.2MP', '4K 30fps', '5-axis stabilization', 'Body only'],
        ]);

        Gadget::create([
            'category_id' => $kamera->id,
            'name' => 'Canon EOS R6 Mark II',
            'image' => $this->seedGadgetImage('Canon EOS R6 Mark II'),
            'brand' => 'Canon',
            'serial_number' => 'CAN-R6MK2-20260002',
            'price_per_day' => 400000,
            'status' => 'available',
            'description' => 'Kamera mirrorless serbaguna dengan autofokus cepat dan performa burst tinggi, cocok untuk foto aksi maupun video profesional.',
            'specs' => ['Sensor full-frame 24.2MP', '4K 60fps', 'In-body stabilization', 'Body only'],
        ]);

        Gadget::create([
            'category_id' => $laptop->id,
            'name' => 'MacBook Air M2',
            'image' => $this->seedGadgetImage('MacBook Air M2'),
            'brand' => 'Apple',
            'serial_number' => 'APL-MBA-M2-20260003',
            'price_per_day' => 250000,
            'status' => 'available',
            'description' => 'Laptop tipis dan ringan dengan chip Apple M2, cocok untuk kerja, desain, dan editing ringan tanpa perlu daya baterai besar.',
            'specs' => ['Chip Apple M2', '8GB RAM', '256GB SSD', 'Layar 13.6" Liquid Retina'],
        ]);

        Gadget::create([
            'category_id' => $konsol->id,
            'name' => 'PlayStation 5',
            'image' => $this->seedGadgetImage('PlayStation 5'),
            'brand' => 'Sony',
            'serial_number' => 'SNY-PS5-20260004',
            'price_per_day' => 150000,
            'status' => 'available',
            'description' => 'Konsol gaming generasi terbaru dengan loading super cepat dan grafis 4K, lengkap dengan satu unit controller DualSense.',
            'specs' => ['4K 120fps', 'SSD ultra-cepat', '1x DualSense controller', 'Ray tracing'],
        ]);

        Gadget::create([
            'category_id' => $konsol->id,
            'name' => 'Nintendo Switch OLED',
            'image' => $this->seedGadgetImage('Nintendo Switch'),
            'brand' => 'Nintendo',
            'serial_number' => 'NTD-SWOLED-20260005',
            'price_per_day' => 100000,
            'status' => 'available',
            'description' => 'Konsol hybrid dengan layar OLED cerah, bisa dimainkan di TV atau mode genggam, cocok buat gaming bareng teman atau keluarga.',
            'specs' => ['Layar OLED 7"', 'Mode TV & handheld', '2x Joy-Con', '64GB storage'],
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
        // 9. Panggil Seeder Lainnya
        // ========================================
        $this->call([
            RentalSeeder::class,
            BlogSeeder::class,
            VoucherSeeder::class,
        ]);
    }

    private function seedGadgetImage($gadgetName)
    {
        $text = urlencode($gadgetName);
        $url = "https://placehold.co/600x400/1a1d26/F59E0B.png?text={$text}";
        
        $filename = 'gadget_' . uniqid() . '.png';
        $path = public_path('images/gadgets');
        
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $context = stream_context_create([
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            "http" => [
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n"
            ]
        ]);
        
        try {
            $imageContent = file_get_contents($url, false, $context);
            if ($imageContent) {
                file_put_contents($path . '/' . $filename, $imageContent);
                return $filename;
            }
        } catch (\Exception $e) {
            // Jika gagal download, return null
        }
        
        return null;
    }
}