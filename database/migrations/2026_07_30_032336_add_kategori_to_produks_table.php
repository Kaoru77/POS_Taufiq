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
        Schema::table('produk', function (Blueprint $table) {
            // Menambahkan kolom 'kategori' setelah kolom 'nama'
            $table->string('kategori')->after('nama')->nullable();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
