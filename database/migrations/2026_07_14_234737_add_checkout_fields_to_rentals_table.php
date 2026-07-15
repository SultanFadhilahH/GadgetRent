<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->nullable()->after('end_date');
            $table->string('payment_method')->nullable()->after('total_amount'); // bank_transfer, qris, cod
            $table->string('payment_status')->default('pending')->after('payment_method'); // pending, paid, failed
            $table->string('delivery_option')->default('pickup')->after('payment_status'); // pickup, delivery
            $table->text('shipping_address')->nullable()->after('delivery_option');
            $table->foreignId('voucher_id')->nullable()->constrained()->nullOnDelete()->after('shipping_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn([
                'total_amount',
                'payment_method',
                'payment_status',
                'delivery_option',
                'shipping_address',
                'voucher_id',
            ]);
        });
    }
};
