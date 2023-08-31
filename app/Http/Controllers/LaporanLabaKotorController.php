<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Kas;
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
        $tanggalMulai   = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());
        
        $totalPemasukan = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->sum('pemasukan');
        
        $totalPengeluaran = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->sum('pengeluaran');
        
        $labaKotor = $totalPemasukan - $totalPengeluaran;
        
        return view('laporan-laba-kotor.index', [
            'totalPemasukan'    => $totalPemasukan,
            'totalPengeluaran'  => $totalPengeluaran,
            'labaKotor'         => $labaKotor,
            'tanggalMulai'      => $tanggalMulai,
            'tanggalSelesai'    => $tanggalSelesai,
        ]);  
    }

    /**
     * Display a Print Laporan laba Kotor.
     */
    public function printLabaKotor(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());
        
        $totalPemasukan = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->sum('pemasukan');
        
        $totalPengeluaran = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])
            ->sum('pengeluaran');
        
        $labaKotor = $totalPemasukan - $totalPengeluaran;

        $checkData = $totalPemasukan || $totalPengeluaran || $labaKotor;
        
        $pdf    = new Dompdf();
        $view   = view('laporan-laba-kotor/print-laba-kotor', compact('totalPemasukan', 'totalPengeluaran','labaKotor', 'tanggalMulai', 'tanggalSelesai', 'checkData'));
        $html   = $view->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-laba-kotor.pdf', ['Attachment' => false]);
    }
}
