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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kd_pembelian')->unique();
            $table->decimal('jumlah_pembayaran', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->decimal('uang_kembalian', 10, 2)->nullable()->default(0);
            $table->integer('diskon');
            $table->integer('ppn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
