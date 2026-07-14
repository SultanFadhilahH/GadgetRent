<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Voucher::truncate();

        \App\Models\Voucher::create([
            'code' => 'GADGET50',
            'discount_type' => 'nominal',
            'discount_value' => 50000,
            'start_date' => '2026-07-01',
            'end_date' => '2026-07-31',
            'usage_count' => 18,
            'is_active' => true,
        ]);

        \App\Models\Voucher::create([
            'code' => 'SEWAHEMAT',
            'discount_type' => 'percent',
            'discount_value' => 10,
            'start_date' => '2026-07-05',
            'end_date' => '2026-07-20',
            'usage_count' => 14,
            'is_active' => true,
        ]);

        \App\Models\Voucher::create([
            'code' => 'NEWUSER',
            'discount_type' => 'percent',
            'discount_value' => 15,
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-30',
            'usage_count' => 5,
            'is_active' => false,
        ]);
    }
}
