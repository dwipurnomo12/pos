<?php

namespace App\Models;

use App\Models\ProdukMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function ProdukMasuk()
    {
        return $this->hasMany(ProdukMasuk::class);
    }
}
