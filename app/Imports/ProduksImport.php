<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduksImport implements ToModel
{
    protected $headerRow = true;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($this->headerRow) {
            $this->headerRow = false;
            return null;
        }

        $user_id    = auth()->user()->id;
        $kategori   = Kategori::firstOrCreate(['kategori'  => $row[7], 'user_id' => $user_id]);
        $satuan     = Satuan::firstOrCreate(['satuan'  => $row[8], 'user_id' => $user_id]);
        $kd_produk  = 'PRD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $produk =  new Produk([
            'kd_produk'     => $kd_produk,
            'nm_produk'     => $row[2],
            'deskripsi'     => $row[3],
            'stok'          => $row[4],
            'harga_beli'    => $row[5],
            'harga_jual'    => $row[6],
            'kategori_id'   => $kategori->id,
            'satuan_id'     => $satuan->id,
            'user_id'       => $user_id,
        ]);

        $produk->save();
        return $produk;
    }
}
