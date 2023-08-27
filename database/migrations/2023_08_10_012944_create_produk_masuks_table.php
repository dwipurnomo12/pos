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
        Schema::create('produk_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('kd_transaksi')->unique();
            $table->string('nm_produk');
            $table->date('tgl_masuk');
            $table->integer('stok_masuk');
            $table->decimal('harga_beli');
            $table->decimal('total_harga');
            $table->foreignId('supplier_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_masuks');
    }
};
