<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
