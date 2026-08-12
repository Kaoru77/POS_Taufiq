<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom kategori_id (sementara nullable)
        Schema::table('produk', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('kategori')->constrained('kategoris')->nullOnDelete();
        });

        // 2. Ambil semua nama kategori unik yang sudah ada di kolom teks lama,
        //    lalu masukkan ke tabel kategoris (kalau belum ada)
        $namaKategoriLama = DB::table('produk')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        foreach ($namaKategoriLama as $nama) {
            DB::table('kategoris')->insertOrIgnore([
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Hubungkan tiap produk ke kategori_id yang sesuai
        $kategoriMap = DB::table('kategoris')->pluck('id', 'nama');

        foreach ($kategoriMap as $nama => $id) {
            DB::table('produk')->where('kategori', $nama)->update(['kategori_id' => $id]);
        }
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};