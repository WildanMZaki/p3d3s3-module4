<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (idempoten dengan updateOrCreate)
        User::updateOrCreate(
            ['username' => 'ali'],
            [
                'id_user'      => 'USR001',
                'password'     => Hash::make('rahasia123'),
                'nama_lengkap' => 'Ali Darmono',
                'email'        => 'ali@example.com',
                'no_hp'        => '081234567890',
                'alamat'       => 'Jl. Gegerkalong Hilir No. 10, Bandung',
            ]
        );

        User::updateOrCreate(
            ['username' => 'siti'],
            [
                'id_user'      => 'USR002',
                'password'     => Hash::make('siti456'),
                'nama_lengkap' => 'Siti Rope\'ah',
                'email'        => 'siti@example.com',
                'no_hp'        => '081298765432',
                'alamat'       => 'Jl. Sukajadi No. 45, Bandung',
            ]
        );

        // 2. Seed Products (Minimal 10 barang, termasuk barang stok 0)
        $products = [
            [
                'id_barang'   => 'BRG001',
                'nama_barang' => 'Buku Tulis Sidu 38 Lembar',
                'deskripsi'   => 'Buku tulis bergaris kualitas standar sekolah.',
                'harga'       => 5000,
                'stok'        => 20,
                'gambar'      => 't2-buku.jpeg',
            ],
            [
                'id_barang'   => 'BRG002',
                'nama_barang' => 'Pulpen Gel Hitam 0.5mm',
                'deskripsi'   => 'Tinta hitam pekat cepat kering dan nyaman digenggam.',
                'harga'       => 3000,
                'stok'        => 30,
                'gambar'      => 't2-pulpen.jpg',
            ],
            [
                'id_barang'   => 'BRG003',
                'nama_barang' => 'Penggaris Besi 30cm',
                'deskripsi'   => 'Penggaris baja antikarat presisi tinggi.',
                'harga'       => 4000,
                'stok'        => 15,
                'gambar'      => 't2-penggaris.jpeg',
            ],
            [
                'id_barang'   => 'BRG004',
                'nama_barang' => 'Pensil 2B Ujian',
                'deskripsi'   => 'Pensil grafit hitam khusus ujian komputer.',
                'harga'       => 2500,
                'stok'        => 25,
                'gambar'      => 't2-pensil-2b.jpeg',
            ],
            [
                'id_barang'   => 'BRG005',
                'nama_barang' => 'Penghapus Karet Putih',
                'deskripsi'   => 'Penghapus bebas debu tidak merusak permukaan kertas.',
                'harga'       => 1500,
                'stok'        => 20,
                'gambar'      => 't2-penghapus.jpeg',
            ],
            [
                'id_barang'   => 'BRG006',
                'nama_barang' => 'Tipe-X Kertas Pita (Correction Tape)',
                'deskripsi'   => 'Pita koreksi praktis panjang 6 meter.',
                'harga'       => 7500,
                'stok'        => 20,
                'gambar'      => null,
            ],
            [
                'id_barang'   => 'BRG007',
                'nama_barang' => 'Gunting Kertas Sedang',
                'deskripsi'   => 'Gunting serbaguna gagang plastik ergonomis.',
                'harga'       => 8000,
                'stok'        => 12,
                'gambar'      => null,
            ],
            [
                'id_barang'   => 'BRG008',
                'nama_barang' => 'Lem Kertas Batang (Glue Stick)',
                'deskripsi'   => 'Lem padat cepat merekat dan tidak berantakan.',
                'harga'       => 5000,
                'stok'        => 18,
                'gambar'      => null,
            ],
            [
                'id_barang'   => 'BRG009',
                'nama_barang' => 'Stabilo Highlighter Kuning',
                'deskripsi'   => 'Penanda teks warna kuning cerah tahan lama.',
                'harga'       => 8500,
                'stok'        => 22,
                'gambar'      => null,
            ],
            [
                'id_barang'   => 'BRG010',
                'nama_barang' => 'Kertas HVS A4 75gsm (1 Rim)',
                'deskripsi'   => 'Kertas fotokopi putih bersih isi 500 lembar.',
                'harga'       => 48000,
                'stok'        => 10,
                'gambar'      => null,
            ],
            [
                'id_barang'   => 'BRG011',
                'nama_barang' => 'Kalkulator Ilmiah Saintifik',
                'deskripsi'   => 'Kalkulator fungsi matematika (Stok Habis / 0).',
                'harga'       => 85000,
                'stok'        => 0, // Barang dengan stok 0 untuk uji proteksi
                'gambar'      => null,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['id_barang' => $item['id_barang']],
                $item
            );
        }
    }
}
