<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Penjualan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $totalProduk            = Produk::count();
        $pemasukanHariIni       = Kas::where('tanggal', Carbon::now()->format('Y-m-d'))->sum('pemasukan');
        $pengeluaranHariIni     = Kas::where('tanggal', Carbon::now()->format('Y-m-d'))->sum('pengeluaran');
        $penjualanHariIni       = Penjualan::where('tgl_transaksi', Carbon::now()->format('Y-m-d'))->sum('sub_total');
        $stokMinimum            = Produk::where('stok', '<=', 10)->get();
        
        return view('home', [
            'totalProduk'        => $totalProduk,
            'pemasukanHariIni'   => $pemasukanHariIni,
            'pengeluaranHariIni' => $pengeluaranHariIni,
            'penjualanHariIni'   => $penjualanHariIni,
            'stokMinimum'        => $stokMinimum
        ]);

    }
}
