<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Stok;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk-masuk.index', [
            'produks'   => Produk::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataProdukMasuk()
    {
        return response()->json([
            'success'   => true,
            'data'      => ProdukMasuk::orderBy('id', 'DESC')->get(),
            'supplier'  => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk-masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_produk'     => 'required',
            'tgl_masuk'     => 'required',
            'harga_beli'    => 'required',
            'harga_jual'    => 'required',
            'stok_masuk'    => 'required',
            'supplier_id'   => 'required'
        ], [
            'nm_produk.required'     => 'Nama Produk Tidak Boleh Kosong !',
            'tgl_masuk.required'     => 'Tanggal Masuk Tidak Boleh Kosong !',
            'harga_beli.required'    => 'Harga Beli Tidak Boleh Kosong !',
            'harga_jual.required'    => 'Harga Jual Tidak Boleh Kosong !',
            'stok_masuk.required'    => 'Stok Masuk Tidak Boleh Kosong ',
            'supplier_id.required'   => 'Wajib Memilih Supplier !'
        ]);

        $kd_transaksi = 'PRD-IN-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $produkMasuk = ProdukMasuk::create([
            'kd_transaksi'   => $kd_transaksi,
            'nm_produk'      => $request->nm_produk,
            'tgl_masuk'      => $request->tgl_masuk,
            'stok_masuk'     => $request->stok_masuk,
            'harga_beli'     => $request->harga_beli,
            'total_harga'    => $request->stok_masuk*$request->harga_beli,
            'user_id'        => auth()->user()->id,
            'supplier_id'    => $request->supplier_id
        ]);

        $tanggalTransaksi = Carbon::now()->toDateString();
        $kasEntry = Kas::where('tanggal', $tanggalTransaksi)->first();

        if ($kasEntry) {
            $kasEntry->pengeluaran += $request->stok_masuk*$request->harga_beli;
            $kasEntry->saldo -= $kasEntry->pengeluaran;
            $kasEntry->save();  
        } else {
            $kasEntry = new Kas();
            $kasEntry->tanggal = $tanggalTransaksi;
            $kasEntry->pengeluaran = $request->stok_masuk*$request->harga_beli;
            $kasEntry->saldo = $request->stok_masuk*$request->harga_beli;
            $kasEntry->save();
        }

        if($produkMasuk){
            $produk = Produk::where('nm_produk', $request->nm_produk)->first();
            if($produk){
                $produk->stok       += $request->stok_masuk;
                $produk->harga_beli = $request->harga_beli;
                $produk->harga_jual = $request->harga_jual;
                $produk->save();
            }
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan',
            'data'      => $produkMasuk
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProdukMasuk $produkMasuk)
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
                'harga_beli'    => $produk->harga_beli,
                'harga_jual'    => $produk->harga_jual
            ]);
        }
    }

}
