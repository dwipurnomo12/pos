<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-penjualan.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getDataPenjualan(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $reportSales = Penjualan::query();
        
        if($tanggalMulai && $tanggalSelesai){
            $reportSales->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai])->with('detailPenjualans');
        }
        $data = $reportSales->get();

        if(empty($tanggalMulai) && empty($tanggalSelesai)){
            $data = Penjualan::with('detailPenjualans')->get();
        }
        return response()->json($data);
    }

    /**
     * Display Print Laporan Pwnjualan/Sales Report
    */
    public function printLaporanPenjualan(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $reportSales = Penjualan::query();
        
        if($tanggalMulai && $tanggalSelesai){
            $reportSales->whereBetween('tgl_transaksi', [$tanggalMulai, $tanggalSelesai])->with('detailPenjualans');
        }

        if($tanggalMulai !== null && $tanggalSelesai !== null) {
            $data = $reportSales->get();
        } else {
            $data = Penjualan::with('detailPenjualans')->get();
        }

        $pdf  = new Dompdf();
        $html = view('laporan-penjualan/print-penjualan', compact('data', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-penjualan.pdf', ['Attachment' => false]);
    }
}
