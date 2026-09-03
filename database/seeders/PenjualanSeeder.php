<?php

namespace Database\Seeders;

use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenjualanSeeder extends Seeder
{
    public function run(): void
    {
        if (Penjualan::count() > 0) {
            $this->command->warn('Sudah ada data penjualan, PenjualanSeeder dilewati.');
            return;
        }
        $kasir = User::whereHas('role', fn ($q) => $q->where('name', 'kasir'))->first()
            ?? User::first();

        $produkList = Produk::all();

        if (!$kasir || $produkList->isEmpty()) {
            $this->command->error('Butuh minimal 1 user dan 1 produk sebelum jalankan seeder ini.');
            return;
        }

        $metodePembayaran = ['CASH', 'CASH', 'QRIS', 'TRANSFER'];

        for ($i = 0; $i < 20; $i++) {
            $penjualan = Penjualan::create([
                'user_id'           => $kasir->id,
                'status'            => 'COMPLETED',
                'metode_pembayaran' => $metodePembayaran[array_rand($metodePembayaran)],
                'total_pembayaran'  => 0,
            ]);

            $jumlahItem = rand(1, 4);
            $produkDipilih = $produkList->random(min($jumlahItem, $produkList->count()));
            $total = 0;

            foreach ($produkDipilih as $produk) {
                $kuantitas = rand(1, 3);
                $subtotal = $kuantitas * $produk->harga_jual;
                $total += $subtotal;

                ItemPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'produk_id'    => $produk->id,
                    'kuantitas'    => $kuantitas,
                    'harga_satuan' => $produk->harga_jual,
                    'subtotal'     => $subtotal,
                ]);

                if ($produk->stok > $kuantitas) {
                    $produk->decrement('stok', $kuantitas);
                }
            }

            $penjualan->update(['total_pembayaran' => $total]);
        }

        $this->command->info('20 transaksi penjualan hari ini berhasil di-seed.');
    }
}