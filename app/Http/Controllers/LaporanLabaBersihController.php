<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kas;
use Illuminate\Http\Request;
use App\Models\BiayaOperasional;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;

class LaporanLabaBersihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun', now()->format('Y-m'));

        $tanggalMulai = Carbon::createFromFormat('Y-m', $bulanTahun)->startOfMonth();
        $tanggalSelesai = Carbon::createFromFormat('Y-m', $bulanTahun)->endOfMonth();

        $totalPemasukan = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pemasukan');
        $totalPengeluaran = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pengeluaran');

        $labaKotor = $totalPemasukan - $totalPengeluaran;

        $totalBiayaOperasional  = BiayaOperasional::sum('biaya'); 
        $labaBersih             = $labaKotor - $totalBiayaOperasional;

        $dataBiayaOperasional = BiayaOperasional::all(); 


        return view('laporan-laba-bersih.index', [
            'totalPemasukan'        => $totalPemasukan,
            'totalPengeluaran'      => $totalPengeluaran,
            'labaBersih'            => $labaBersih,
            'bulanTahun'            => $bulanTahun,
            'dataBiayaOperasional'  => $dataBiayaOperasional, 
        ]);
    }

    /**
     * Display a Print Laporan laba Bersih.
     */
    public function printLabaBersih(Request $request)
    {
        $bulanTahun = $request->input('bulan_tahun', now()->format('Y-m'));

        $tanggalMulai = Carbon::createFromFormat('Y-m', $bulanTahun)->startOfMonth();
        $tanggalSelesai = Carbon::createFromFormat('Y-m', $bulanTahun)->endOfMonth();

        $totalPemasukan = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pemasukan');
        $totalPengeluaran = Kas::whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai])->sum('pengeluaran');

        $labaKotor = $totalPemasukan - $totalPengeluaran;

        $totalBiayaOperasional  = BiayaOperasional::sum('biaya'); 
        $labaBersih             = $labaKotor - $totalBiayaOperasional;

        $dataBiayaOperasional = BiayaOperasional::all(); 

        $pdf = new Dompdf();
        $view = view('laporan-laba-bersih/print-laba-bersih', compact('bulanTahun', 'totalPemasukan', 'totalPengeluaran', 'totalBiayaOperasional', 'labaBersih', 'dataBiayaOperasional'));
        $html   = $view->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-laba-bersih.pdf', ['Attachment' => false]);

    }
}
