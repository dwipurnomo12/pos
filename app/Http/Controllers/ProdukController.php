<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Imports\ProduksImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk.index', [
            'kategories' => Kategori::with(['kategori', 'satuan'])->orderBy('id', 'DESC')->get(),
            'satuans'    => Satuan::all()
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataProduk()
    {
        return response()->json([
            'success' => true,
            'data'    => Produk::with(['kategori', 'satuan'])->orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nm_produk'     => 'required',
            'deskripsi'     => 'required',
            'kategori_id'   => 'required',
            'satuan_id'     => 'required',
        ], [
            'nm_produk.required'    => 'Nama Produk Tidak Boleh Kosong !',
            'deskripsi.required'    => 'Deskripsi Tidak Boleh Kosong !',
            'kategori_id.required'  => 'Pilih Kategori !',
            'satuan_id.required'    => 'Pilih Satuan !',
        ]);

        $kd_produk = 'PRD-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk = Produk::create([
            'kd_produk'     => $kd_produk,
            'nm_produk'     => $request->nm_produk,
            'deskripsi'     => $request->deskripsi,
            'kategori_id'   => $request->kategori_id,
            'satuan_id'     => $request->satuan_id,
            'user_id'       => auth()->user()->id,
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan',
            'data'      => $produk
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Produk::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Produk',
            'data'      => $produk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $produk = Produk::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Produk',
            'data'      => $produk
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $validator = Validator::make($request->all(), [
            'nm_produk'     => 'required',
            'harga_jual'    => 'required',
            'deskripsi'     => 'required',
            'kategori_id'   => 'required',
            'satuan_id'     => 'required',
        ], [
            'nm_produk.required'    => 'Nama Produk Tidak Boleh Kosong !',
            'deskripsi.required'    => 'Deskripsi Tidak Boleh Kosong !',
            'harga_jual'            => 'Harga Jual Tidak Boleh Kosong !',
            'kategori_id.required'  => 'Pilih Kategori !',
            'satuan_id.required'    => 'Pilih Satuan !',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produk->update([
            'nm_produk'     => $request->nm_produk,
            'harga_jual'    => $request->harga_jual,
            'deskripsi'     => $request->deskripsi,
            'kategori_id'   => $request->kategori_id,
            'satuan_id'     => $request->satuan_id,
            'user_id'       => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $produk
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Produk::find($id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus !'
        ]);
    }

    /**
     * Import data excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file'  => 'required|file|mimes:xlsx,xls'
        ], [
            'file.required'     => 'Tidak boleh kosong !',
            'file.file'         => 'Harus ber-type file !',
            'file.mimes'        => 'FOrmat yang di izinkan xlsx, xls'
        ]);

        $file = $request->file('file');
        Excel::import(new ProduksImport, $file);
        return redirect('/produk')->with('success', 'Data produk berhasil di Import !');
    }
}
