<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use App\Http\Controllers\Controller;
use App\Models\SettingPenjualan;

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
        $nm_pelanggan       = $request->input('nm_pelanggan');
        $jumlah_pembayaran  = $request->input('jumlah_pembayaran');
        $status             = $request->input('status');
        $subTotal           = $request->input('sub_total');
        $diskon             = $request->input('diskon');
        $ppn                = $request->input('ppn');

        $pembelian = new Pembelian();
        $pembelian->kd_pembelian        = $kd_pembelian;
        $pembelian->jumlah_pembayaran   = $jumlah_pembayaran;
        $pembelian->sub_total           = $subTotal;
        $pembelian->diskon              = $diskon;
        $pembelian->ppn                 = $ppn;
        if ($status === '1') { // Jika pembayaran hutang
            $uang_kekurangan = $request->input('uang_kekurangan');
            $pembelian->status = 'hutang';
            $pembelian->uang_kekurangan = $uang_kekurangan;
            $pembelian->nm_pelanggan = $nm_pelanggan;
        } else if ($status === '2') { // Jika pembayaran cash
            $uang_kembalian = $request->input('uang_kembalian');
            $pembelian->status = 'lunas';
            $pembelian->uang_kembalian = $uang_kembalian;
        }
        $pembelian->save();

        foreach ($request->input('pembelian_item') as $item) {
            $detailPembelian = new DetailPembelian();
            $detailPembelian->nm_produk             = $item['nm_produk'];
            $detailPembelian->harga_produk          = $item['harga_produk'];
            $detailPembelian->quantity              = $item['quantity'];
            $detailPembelian->total_harga_produk    = $item['total_harga_produk'];
            $detailPembelian->pembelian_id          = $pembelian->id;
            $detailPembelian->save();

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
