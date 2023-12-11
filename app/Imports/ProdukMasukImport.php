<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\ProdukMasuk;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProdukMasukImport implements ToModel
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

        $user_id      = auth()->user()->id;
        $kd_transaksi = 'PRD-IN-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $tgl_masuk    = Carbon::now();
        $supplier     = Supplier::firstOrCreate([
            'supplier' => $row[7],
            'user_id'  => $user_id,
            'alamat'   => 'Purworejo'
        ]);

        $produkMasuk = new ProdukMasuk([
            'kd_transaksi'  => $kd_transaksi,
            'nm_produk'     => $row[2],
            'tgl_masuk'     => $tgl_masuk,
            'stok_masuk'    => $row[4],
            'harga_beli'    => $row[5],
            'total_harga'   => $row[4] * $row[5],
            'supplier_id'   => $supplier->id,
            'user_id'       => $user_id
        ]);

        $produk                 = Produk::where('nm_produk', $row[2])->first();
        $tanggalTransaksi       = Carbon::now()->toDateString();
        $hariSebelumnya         = Carbon::yesterday()->toDateString();
        $kasEntryHariIni        = Kas::where('tanggal', $tanggalTransaksi)->first();
        $kasEntryHariSebelumnya = Kas::where('tanggal', $hariSebelumnya)->first();

        $pengeluaran = $row[4] * $produk->harga_beli;

        if ($kasEntryHariIni) {
            $kasEntryHariIni->pengeluaran += $pengeluaran;
            $kasEntryHariIni->saldo -= $pengeluaran;
            $kasEntryHariIni->save();
        } else {
            $kasEntryHariIni = new Kas();
            $kasEntryHariIni->tanggal = $tanggalTransaksi;
            if ($kasEntryHariSebelumnya) {
                $kasEntryHariIni->saldo = $kasEntryHariSebelumnya->saldo;
            }
            $kasEntryHariIni->pengeluaran = $pengeluaran;
            $kasEntryHariIni->saldo -= $pengeluaran;
            $kasEntryHariIni->save();
        }

        if ($produkMasuk) {
            $produk = Produk::where('nm_produk', $row[2])->first();
            if ($produk) {
                $produk->stok       += $row[4];
                $produk->harga_beli = $row[5];
                $produk->harga_jual = $produk->harga_jual;
                $produk->save();
            }
        }

        $produkMasuk->save();
        return $produkMasuk;
    }
}
