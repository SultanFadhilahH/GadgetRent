<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Perlebar enum status di rentals agar mendukung 'pending'
        DB::statement("ALTER TABLE `rentals` MODIFY COLUMN `status` ENUM('pending', 'ongoing', 'completed', 'overdue') NOT NULL DEFAULT 'pending'");

        // Buat customer_id nullable (untuk checkout yang tidak memakai tabel customers)
        Schema::table('rentals', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `rentals` MODIFY COLUMN `status` ENUM('ongoing', 'completed', 'overdue') NOT NULL DEFAULT 'ongoing'");

        Schema::table('rentals', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
        });
    }
};
