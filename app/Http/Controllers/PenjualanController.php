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
            'produks'   => Produk::all(),
            'diskon_enabled'    => $settingPenjualan->diskon_enabled == 1,
            'ppn_enabled'       => $settingPenjualan->ppn_enabled == 1,
            'diskonPresentase'  => $settingPenjualan->diskon_presentase,
            'ppnPresentase'     => $settingPenjualan->ppn_presentase,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric',
            'pembelian_item'    => 'required|array',
            'sub_total'          => 'required|numeric',
        ]);

        $kd_pembelian       = 'INV-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $jumlah_pembayaran  = $request->input('jumlah_pembayaran');
        $subTotal           = $request->input('sub_total');
        $uangKembalian      = $request->input('uang_kembalian');
        $diskon             = $request->input('diskon');;
        $ppn                = $request->input('ppn');;

        $pembelian = new Pembelian();
        $pembelian->kd_pembelian        = $kd_pembelian;
        $pembelian->jumlah_pembayaran   = $jumlah_pembayaran;
        $pembelian->sub_total           = $subTotal;
        $pembelian->uang_kembalian      = $uangKembalian;
        $pembelian->diskon              = $diskon;
        $pembelian->ppn                 = $ppn;
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

        return response()->json(['message' => 'Data pembelian berhasil disimpan'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
