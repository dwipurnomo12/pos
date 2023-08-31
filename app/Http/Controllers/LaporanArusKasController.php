<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Dompdf\Dompdf;

class LaporanArusKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-arus-kas.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getDataArusKas(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $arusKas = Kas::query();

        if($tanggalMulai && $tanggalSelesai){
            $arusKas->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        $data = $arusKas->get();

        if(empty($tanggalMulai) && empty($tanggalSelesai)){
            $data = Kas::all();
        }

        return response()->json($data);
    }

    /**
     * Display Print Laporan Arus Kas
     */
    public function printLaporanArusKas(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $arusKas = Kas::query();

        if($tanggalMulai && $tanggalSelesai){
            $arusKas->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }

        if($tanggalMulai !== null && $tanggalSelesai !== null){
            $data = $arusKas->get();
        } else {
            $data = Kas::all();
        }

        $pdf = new Dompdf();
        $html = view('laporan-arus-kas/print-arus-kas', compact('data', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-arus-kas.pdf', ['Attachment' => false]);
    }
}