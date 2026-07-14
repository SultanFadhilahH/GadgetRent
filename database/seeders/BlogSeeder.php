<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Blog::truncate(); // Hapus data lama agar tidak duplikat

        \App\Models\Blog::create([
            'category' => 'TIPS & TRIK',
            'title' => 'Cara Merawat Baterai Kamera Mirrorless Agar Lebih Awet Saat Disewa',
            'excerpt' => 'Menjaga baterai kamera mirrorless tetap awet sangat penting bagi fotografer. Simak tips cara mengisi daya, menyimpannya dengan benar, serta kesalahan umum yang harus dihindari.',
            'external_link' => 'https://dorangadget.com/cara-merawat-batrai-kamera/?srsltid=AfmBOoqFLQ8AvAkW3KCS1asFWG37M83ZUAVDP1T2whz3an642Usd4lAB',
            'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=800&auto=format&fit=crop',
            'published_at' => now()->subDays(2),
        ]);

        \App\Models\Blog::create([
            'category' => 'REVIEW',
            'title' => 'Review MacBook Air M2 Untuk Desain Grafis: Apakah Layak?',
            'excerpt' => 'Membahas kemampuan MacBook Air M2 sebagai perangkat utama. Apakah spesifikasinya sudah cukup tangguh untuk menangani kebutuhan desain grafis masa kini?',
            'external_link' => 'https://www.terbitindo.com/19867/review-macbook-air-m2-untuk-desain-grafis-apakah-layak/',
            'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=800&auto=format&fit=crop',
            'published_at' => now()->subDays(5),
        ]);

        \App\Models\Blog::create([
            'category' => 'BERITA',
            'title' => 'PS5 Pro Akan Diluncurkan, Apa Yang Baru Dari Produk Ini?',
            'excerpt' => 'Sony tengah bersiap meluncurkan iterasi terbaru konsol mereka, PS5 Pro. Simak berbagai pembaruan fitur dan peningkatan spesifikasi grafis yang ditawarkannya.',
            'external_link' => 'https://www.tempo.co/sains/ps5-pro-akan-diluncurkan-apa-yang-baru-dari-produk-ini--9559',
            'image_url' => 'https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?q=80&w=800&auto=format&fit=crop',
            'published_at' => now()->subDays(10),
        ]);
    }
}
