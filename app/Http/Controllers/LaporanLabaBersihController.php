<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanLabaBersihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());

        $totalPemasukan = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pemasukan');

        $totalPengeluaran = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pengeluaran');

        $labaBersih = $totalPemasukan - $totalPengeluaran;

        return view('laporan-laba-bersih.index', [
            'totalPemasukan'    => $totalPemasukan,
            'totalPengeluaran'  => $totalPengeluaran,
            'labaBersih'         => $labaBersih,
            'tanggalMulai'      => $tanggalMulai,
            'tanggalSelesai'    => $tanggalSelesai,
        ]);
    }
}
