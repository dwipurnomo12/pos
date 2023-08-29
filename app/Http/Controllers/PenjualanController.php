<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;
use App\Models\SettingPenjualan;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settingPenjualan = SettingPenjualan::first();
        return view('menu-penjualan.index', [
            'produks'           => Produk::where('stok', '>', 0)->get(),
            'diskon_enabled'    => $settingPenjualan->diskon_enabled == 1,
            'ppn_enabled'       => $settingPenjualan->ppn_enabled == 1,
            'diskonPresentase'  => $settingPenjualan->diskon_presentase,
            'ppnPresentase'     => $settingPenjualan->ppn_presentase,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kd_pembelian       = 'INV-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $jumlah_pembayaran  = $request->input('jumlah_pembayaran');
        $subTotal           = $request->input('sub_total');
        $diskon             = $request->input('diskon');
        $ppn                = $request->input('ppn');
        $uang_kembalian     = $request->input('uang_kembalian');

        $penjualan = new Penjualan();
        $penjualan->kd_pembelian        = $kd_pembelian;
        $penjualan->tgl_transaksi       = Carbon::now()->toDateString();
        $penjualan->jumlah_pembayaran   = $jumlah_pembayaran;
        $penjualan->sub_total           = $subTotal;
        $penjualan->diskon              = $diskon;
        $penjualan->ppn                 = $ppn;
        $penjualan->save();

        $tanggalTransaksi = Carbon::now()->toDateString();
        $kasEntry = Kas::where('tanggal', $tanggalTransaksi)->first();

        if ($kasEntry) {
            $kasEntry->pemasukan += $jumlah_pembayaran;
            $kasEntry->pengeluaran += $uang_kembalian;
            $kasEntry->saldo = $kasEntry->pemasukan - $kasEntry->pengeluaran;
            $kasEntry->save();
        } else {
            $kasEntry = new Kas();
            $kasEntry->tanggal = $tanggalTransaksi;
            $kasEntry->pemasukan = $jumlah_pembayaran;
            $kasEntry->pengeluaran = $uang_kembalian;
            $kasEntry->saldo = $jumlah_pembayaran - $uang_kembalian;
            $kasEntry->save();
        }        

        foreach ($request->input('penjualan_item') as $item) {
            $detailPenjualan = new DetailPenjualan();
            $detailPenjualan->nm_produk             = $item['nm_produk'];
            $detailPenjualan->harga_produk          = $item['harga_produk'];
            $detailPenjualan->quantity              = $item['quantity'];
            $detailPenjualan->total_harga_produk    = $item['total_harga_produk'];
            $detailPenjualan->penjualan_id          = $penjualan->id;
            $detailPenjualan->save();

            $produkStok = Produk::where('nm_produk', $item['nm_produk'])->first();
            if($produkStok){
                $updateStok = $produkStok->stok - $item['quantity'];
                $produkStok->update(['stok' => $updateStok]);
            }
        }

        return response()->json([
            'kd_pembelian'  => $kd_pembelian,
            'message'       => 'Data pembelian berhasil disimpan'
        ], 200);
    }


    /**
     * Create Autocomplete Data
    */
    public function getAutoCompleteData(Request $request)
    {
        $produk = Produk::where('nm_produk', $request->nm_produk)->first();
        if($produk){
            return response()->json([
                'nm_produk'     => $produk->nm_produk,
                'stok'          => $produk->stok,
                'harga_jual'    => $produk->harga_jual
            ]);
        }
    }
}
