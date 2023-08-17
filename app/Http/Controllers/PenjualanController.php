<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use App\Http\Controllers\Controller;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('menu-penjualan.index', [
            'produks'   => Produk::all()
        ]);
    }

    /**
     * Display & Proses pembelian .
    */
    public function pembelian(Request $request)
{
    $kd_pembelian       = 'INV-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $jenis_pembayaran   = $request->input('jenis_pembayaran');
    $jumlah_pembayaran  = $request->input('jumlah_pembayaran');

    $pembelian = new Pembelian();
    $pembelian->kd_pembelian        = $kd_pembelian;
    $pembelian->jenis_pembayaran    = $jenis_pembayaran;
    $pembelian->jumlah_pembayaran   = $jumlah_pembayaran;
    $pembelian->save();

    // $detailPembelianData = $dataPembelian['produk_item'];
    // foreach ($detailPembelianData as $item) {
    //     $detailPembelian = new DetailPembelian();
    //     $detailPembelian->kd_pembelian = $kd_pembelian; // Hubungkan dengan kode pembelian yang baru dibuat
    //     $detailPembelian->nm_produk = $item['nm_produk'];
    //     $detailPembelian->harga_produk = $item['harga_produk'];
    //     $detailPembelian->quantity = $item['quantity'];
    //     $detailPembelian->total_harga_produk = $item['total_harga_produk'];
    //     $detailPembelian->save();
    // }

    // Kembalikan respons
    return response()->json(['message' => 'Data pembelian berhasil disimpan']);
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
        //
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
