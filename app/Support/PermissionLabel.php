<?php

namespace App\Support;

class PermissionLabel
{
    /**
     * Peta nama permission (system name) ke label berbahasa Indonesia
     * yang ditampilkan di halaman Manajemen User.
     *
     * @var array<string, string>
     */
    public const MAP = [
        'manage-categories-gadgets' => 'Kelola kategori & gadget',
        'manage-rentals' => 'Kelola transaksi rental',
        'manage-returns-fines' => 'Kelola pengembalian & denda',
        'manage-users-roles' => 'Kelola pengguna & peran',
        'full-reports-access' => 'Akses laporan penuh',
        'create-manage-transactions' => 'Buat & kelola transaksi',
        'view-gadget-status' => 'Lihat status gadget',
        'process-returns-fines' => 'Proses pengembalian & denda',
        'manage-customer-data' => 'Kelola data customer',
    ];

    /**
     * Ambil label berbahasa Indonesia untuk sebuah permission.
     * Jika tidak ditemukan di peta, permission akan diformat otomatis
     * dari format kebab-case menjadi kalimat biasa.
     */
    public static function label(string $permissionName): string
    {
        if (isset(self::MAP[$permissionName])) {
            return self::MAP[$permissionName];
        }

        return ucfirst(str_replace('-', ' ', $permissionName));
    }
}