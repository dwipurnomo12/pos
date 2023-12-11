<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use App\Models\Stok;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use App\Imports\ProdukMasukImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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
            'data'      => ProdukMasuk::with('supplier')->orderBy('id', 'DESC')->get(),
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


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $produkMasuk = ProdukMasuk::create([
            'kd_transaksi'   => $kd_transaksi,
            'nm_produk'      => $request->nm_produk,
            'tgl_masuk'      => $request->tgl_masuk,
            'stok_masuk'     => $request->stok_masuk,
            'harga_beli'     => $request->harga_beli,
            'total_harga'    => $request->stok_masuk * $request->harga_beli,
            'user_id'        => auth()->user()->id,
            'supplier_id'    => $request->supplier_id
        ]);

        $tanggalTransaksi = Carbon::now()->toDateString();
        $hariSebelumnya = Carbon::yesterday()->toDateString();
        $kasEntryHariIni = Kas::where('tanggal', $tanggalTransaksi)->first();
        $kasEntryHariSebelumnya = Kas::where('tanggal', $hariSebelumnya)->first();

        $pengeluaran = $request->stok_masuk * $request->harga_beli;

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
            $produk = Produk::where('nm_produk', $request->nm_produk)->first();
            if ($produk) {
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
     * Create Autocomplete Data
     */
    public function getAutoCompleteData(Request $request)
    {
        $produk = Produk::where('nm_produk', $request->nm_produk)->first();
        if ($produk) {
            return response()->json([
                'nm_produk'     => $produk->nm_produk,
                'stok'          => $produk->stok,
                'harga_beli'    => $produk->harga_beli,
                'harga_jual'    => $produk->harga_jual
            ]);
        }
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
        Excel::import(new ProdukMasukImport, $file);
        return redirect('/produk-masuk')->with('success', 'Data produk berhasil di Import !');
    }
}
