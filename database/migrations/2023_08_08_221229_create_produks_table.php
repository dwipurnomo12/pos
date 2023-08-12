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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('kd_produk')->unique();
            $table->string('nm_produk');
            $table->text('deskripsi');
            $table->integer('stok')->nullable()->default('0');
            $table->decimal('harga_beli')->nullable()->default('0');
            $table->decimal('harga_jual')->nullable()->default('0');
            $table->foreignId('kategori_id');
            $table->foreignId('supplier_id');
            $table->foreignId('satuan_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
