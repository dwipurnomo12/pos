<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}
