<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $namaKategori = ['Roti', 'Donat', 'Kue', 'Pastry', 'Cookies', 'Dessert', 'Minuman'];

        foreach ($namaKategori as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }

        $this->command->info('7 kategori bakery berhasil di-seed.');
    }
}