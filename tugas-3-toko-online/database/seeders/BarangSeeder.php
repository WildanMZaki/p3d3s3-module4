<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 20, 'gambar' => 't2-buku.jpeg'],
            ['nama' => 'Pulpen', 'harga' => 3000, 'stok' => 30, 'gambar' => 't2-pulpen.jpg'],
            ['nama' => 'Penggaris', 'harga' => 4000, 'stok' => 15, 'gambar' => 't2-penggaris.jpeg'],
            ['nama' => 'Pensil 2B', 'harga' => 2500, 'stok' => 25, 'gambar' => 't2-pensil-2b.jpeg'],
            ['nama' => 'Penghapus', 'harga' => 1500, 'stok' => 20, 'gambar' => 't2-penghapus.jpeg'],
        ];

        foreach ($items as $item) {
            Barang::updateOrCreate(
                ['nama' => $item['nama']],
                $item
            );
        }
    }
}
