<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\ProdukMasuk;
use App\Models\ProdukKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanLabaKotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        
        // Hitung total pendapatan dari Penjualan Kasir dalam rentang tanggal tertentu
        $totalPendapatan = Penjualan::whereBetween('tgl_transaksi', [$tanggalAwal, $tanggalAkhir])
            ->sum('sub_total');

        // Hitung total biaya dari Produk Masuk dalam rentang tanggal tertentu
        $totalBiayaProdukMasuk = ProdukMasuk::whereBetween('tgl_masuk', [$tanggalAwal, $tanggalAkhir])
            ->sum('total_harga');

        // Hitung total biaya dari Produk Keluar Rusak/Expired dalam rentang tanggal tertentu
        $totalBiayaProdukKeluar = ProdukKeluar::whereBetween('tgl_keluar', [$tanggalAwal, $tanggalAkhir])
            ->sum('total_harga');

        // Hitung laba kotor
        $labaKotor = $totalPendapatan - ($totalBiayaProdukMasuk + $totalBiayaProdukKeluar);

        return view('laporan-laba-kotor.index', [
            'totalPendapatan' => $totalPendapatan,
            'totalBiayaProdukMasuk' => $totalBiayaProdukMasuk,
            'totalBiayaProdukKeluar' => $totalBiayaProdukKeluar,
            'labaKotor' => $labaKotor,
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getLaporanLabaKotor(Request $request)
    {
 
    }
}
