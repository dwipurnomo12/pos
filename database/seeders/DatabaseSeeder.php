<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kas;
use App\Models\Role;
use App\Models\User;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Rentang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use App\Models\BiayaOperasional;
use App\Models\SettingPenjualan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name'      => 'admin',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('1234'),
            'role_id'   => 1
        ]);

        Produk::create([
            'kd_produk'     => 'PRD-3623',
            'nm_produk'     => 'Indomie Goreng',
            'deskripsi'     => 'Indomie Goreng',
            'stok'          => 0,
            'harga_beli'    => 2000,
            'harga_jual'    => 2500,
            'kategori_id'   => 1,
            'satuan_id'     => 1,
            'user_id'       => 1
        ]);

        Kategori::create([
            'kategori'  => 'Makanan',
            'user_id'   => 1
        ]);
        Kategori::create([
            'kategori'  => 'Sabun',
            'user_id'   => 1
        ]);

        Satuan::create([
            'satuan'  => 'Pcs',
            'user_id'   => 1
        ]);
        Satuan::create([
            'satuan'  => 'Unit',
            'user_id'   => 1
        ]);

        Supplier::create([
            'supplier'  => 'Toko 51 Baledono',
            'alamat'    => 'Baledono, Purworejo',
            'user_id'   => 1
        ]);
        Supplier::create([
            'supplier'  => 'Toko Daya Agung Purworejo',
            'alamat'    => 'Baledono, Purworejo',
            'user_id'   => 1
        ]);

        SettingPenjualan::create([
            'diskon_enabled'    => 1,
            'diskon_presentase' => 0.10,
            'ppn_enabled'       => 1,
            'ppn_presentase'    => 0.10
        ]);
        
        Kas::create([
            'tanggal'       => now()->toDateString(),
            'saldo'         => 100000.00,
            'pengeluaran'   => 0.00,
            'pemasukan'     => 0.00
        ]);

        Role::create([
            'role'  => 'admin',
        ]);
        Role::create([
            'role'  => 'kepala toko',
        ]);
        Role::create([
            'role'  => 'kasir',
        ]);
    }
}
