<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::first()?->id;

        if (!$userId) {
            $this->command->error('Tidak ada user di database. Buat akun dulu sebelum jalankan seeder ini.');
            return;
        }

        $kategoriData = [
            'Roti' => [
                'items' => ['Roti Cokelat', 'Roti Keju', 'Roti Sosis', 'Roti Abon', 'Roti Kismis', 'Roti Tawar', 'Roti Gandum'],
                'harga' => [10000, 18000],
            ],
            'Donat' => [
                'items' => ['Donat Glaze', 'Donat Cokelat', 'Donat Strawberry', 'Donat Matcha', 'Donat Tiramisu', 'Donat Oreo'],
                'harga' => [8000, 12000],
            ],
            'Kue' => [
                'items' => ['Black Forest', 'Red Velvet', 'Cheesecake', 'Brownies', 'Tiramisu Cake', 'Chiffon Cake', 'Bolu Kukus'],
                'harga' => [30000, 45000],
            ],
            'Pastry' => [
                'items' => ['Croissant', 'Danish Chocolate', 'Apple Pie', 'Puff Pastry', 'Pain au Chocolat'],
                'harga' => [18000, 30000],
            ],
            'Cookies' => [
                'items' => ['Choco Chip Cookies', 'Butter Cookies', 'Oatmeal Cookies', 'Almond Cookies', 'Nastar', 'Kastengel'],
                'harga' => [20000, 32000],
            ],
            'Dessert' => [
                'items' => ['Cupcake Vanilla', 'Cupcake Red Velvet', 'Pudding Cokelat', 'Panna Cotta', 'Muffin Blueberry'],
                'harga' => [15000, 22000],
            ],
            'Minuman' => [
                'items' => ['Kopi Hitam', 'Cappuccino', 'Latte', 'Americano', 'Matcha Latte', 'Chocolate', 'Lemon Tea', 'Mineral Water'],
                'harga' => [8000, 28000],
            ],
        ];

        foreach ($kategoriData as $kategori => $data) {
            foreach ($data['items'] as $nama) {
                $hargaJual = round(rand($data['harga'][0], $data['harga'][1]) / 500) * 500;
                $hargaBeli = round(($hargaJual * 0.62) / 500) * 500;

                Produk::create([
                    'user_id'    => $userId,
                    'foto'       => null,
                    'nama'       => $nama,
                    'kategori'   => $kategori,
                     'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'stok'       => rand(10, 50),
                ]);
            }
        }

        $this->command->info('44 produk bakery berhasil di-seed.');
    }
}