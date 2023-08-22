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
        Schema::create('setting_penjualans', function (Blueprint $table) {
            $table->id();
            $table->boolean('diskon_enabled')->default(false);
            $table->integer('diskon_presentase')->nullable();
            $table->boolean('ppn_enabled')->default(false);
            $table->integer('ppn_presentase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_penjualans');
    }
};
