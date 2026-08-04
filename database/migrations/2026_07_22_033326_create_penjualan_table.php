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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id(); // Harus ->id()
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // PASTIKAN BARIS INI TIPE STRING:
            $table->string('status')->default('OPEN');

            $table->integer('total_pembayaran')->default(0);
            $table->string('metode_pembayaran')->default('CASH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
