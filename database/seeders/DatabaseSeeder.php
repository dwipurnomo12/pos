<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Satuan;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

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
            'password'  => bcrypt('1234')
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
    }
}
