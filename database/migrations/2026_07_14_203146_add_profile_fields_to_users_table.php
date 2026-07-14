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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('ktp_image_path')->nullable();
            $table->timestamp('ktp_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'nik',
                'phone',
                'birth_date',
                'gender',
                'ktp_image_path',
                'ktp_verified_at',
            ]);
        });
    }
};
