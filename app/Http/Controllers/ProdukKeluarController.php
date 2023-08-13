<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use App\Models\ProdukKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class ProdukKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk-keluar.index', [
            'produks'   => Produk::all(),
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataProdukKeluar()
    {
        return response()->json([
            'success'   => true,
            'data'      => ProdukKeluar::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk-keluar.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_produk'     => 'required',
            'tgl_keluar'    => 'required',
            'deskripsi'     => 'required',
            'stok_keluar'   => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    $nm_produk  = $request->nm_produk;
                    $produk     = Produk::where('nm_produk', $nm_produk)->first();
        
                    if ($value > $produk->stok) {
                        $fail("Stok Tidak Cukup !");
                    }
                },
            ],
        ], [
            'nm_produk.required'    => 'Nama Produk Tidak Boleh Kosong !',
            'tgl_keluar.required'   => 'Tanggal Keluar Tidak Boleh Kosong !',
            'deskripsi.required'    => 'Deskripsi Tidak Boleh Keluar',
            'stok_keluar.required'  => 'Stok Keluar Tidak Boleh Kosong',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kd_transaksi = 'PRD-OUT-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        $produkKeluar = ProdukKeluar::create([
            'kd_transaksi'   => $kd_transaksi,
            'nm_produk'      => $request->nm_produk,
            'tgl_keluar'     => $request->tgl_keluar,
            'stok_keluar'    => $request->stok_keluar,
            'deskripsi'      => $request->deskripsi,
            'user_id'        => auth()->user()->id,
        ]);

        if($produkKeluar){
            $produk = Produk::where('nm_produk', $request->nm_produk)->first();
            if($produk){
                $produk->stok -= $request->stok_keluar;
                $produk->save();
            }
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan',
            'data'      => $produkKeluar
        ]);
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
            ]);
        }
    }


}
