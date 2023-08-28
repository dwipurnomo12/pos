<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\ProdukKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;

class LaporanProdukKeluarController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-produk-keluar.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getlaporanProdukKeluar(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $produkKeluar   = ProdukKeluar::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkKeluar->whereBetween('tgl_keluar', [$tanggalMulai, $tanggalSelesai]);
        }

        $data = $produkKeluar->get();

        if(empty($tanggalMulai) && empty($tanggalSelesai)){
            $data = ProdukKeluar::all();
        }

        return response()->json($data);
    }

    /**
     * Display Print Laporan Produk Keluar
     */
    public function printLaporanProdukKeluar(Request $request)
    {
        $tanggalMulai    = $request->input('tanggal_mulai');
        $tanggalSelesai  = $request->input('tanggal_selesai');

        $produkKeluar   = ProdukKeluar::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkKeluar->whereBetween('tgl_keluar', [$tanggalMulai, $tanggalSelesai]);
        }

        if($tanggalMulai !== null && $tanggalSelesai !== null) {
            $data = $produkKeluar->get();
        } else {
            $data = ProdukKeluar::all();
        }

        $pdf  = new Dompdf();
        $html = view('laporan-produk-keluar/print-produk-keluar', compact('data', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-produk-keluar.pdf', ['Attachment' => false]);
    }
}
