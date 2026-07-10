<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use Carbon\Carbon;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        // Menghapus data rental lama agar tidak menumpuk saat di-seed ulang
        Rental::truncate();

        $data = [
            [
                'invoice_code' => 'INV-20260703-001',
                'user_id' => 1, // Diambil oleh Admin Toko (ID: 1)
                'customer_id' => 1, // Budi Santoso
                'gadget_id' => 2, // Canon EOS R6 Mark II
                'start_date' => '2026-07-03',
                'end_date' => '2026-07-06',
                'actual_return_date' => null,
                'total_price' => 1200000,
                'status' => 'ongoing',
            ],
            [
                'invoice_code' => 'INV-20260702-004',
                'user_id' => 1,
                'customer_id' => 2, // Siti Rahayu
                'gadget_id' => 5, // Nintendo Switch OLED
                'start_date' => '2026-06-28',
                'end_date' => '2026-07-02',
                'actual_return_date' => null,
                'total_price' => 400000,
                'status' => 'overdue',
            ],
            [
                'invoice_code' => 'INV-20260625-003',
                'user_id' => 1,
                'customer_id' => 1, // Budi Santoso
                'gadget_id' => 3, // MacBook Air M2
                'start_date' => '2026-06-20',
                'end_date' => '2026-06-25',
                'actual_return_date' => '2026-06-25',
                'total_price' => 1250000,
                'status' => 'completed',
            ],
            [
                'invoice_code' => 'INV-20260615-002',
                'user_id' => 1,
                'customer_id' => 2, // Siti Rahayu
                'gadget_id' => 4, // PlayStation 5
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-15',
                'actual_return_date' => '2026-06-15',
                'total_price' => 450000,
                'status' => 'completed',
            ],
        ];

        foreach ($data as $rental) {
            Rental::create($rental);
        }
    }
}
