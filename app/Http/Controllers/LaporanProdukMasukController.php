<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;

use function Termwind\render;

class LaporanProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-produk-masuk.index');
    }

    /**
     * Display Get Supplier
     */
    public function getSupplier()
    {
        $supplier = Supplier::all();
        return response()->json($supplier);
    }

    /**
     * Display a Fetch Data
     */
    public function getLaporanProdukMasuk(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $produkMasuk = ProdukMasuk::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkMasuk->whereBetween('tgl_masuk', [$tanggalMulai, $tanggalSelesai]);
        }

        $data = $produkMasuk->get();

        if (empty($tanggalMulai) && empty($tanggalSelesai)) {
            $data = ProdukMasuk::all();
        } 

        return response()->json($data);
    }

    /**
     * Display Print Laporan Produk Masuk
     */
    public function printLaporanProdukMasuk(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        $produkMasuk = ProdukMasuk::query();

        if($tanggalMulai && $tanggalSelesai){
            $produkMasuk->whereBetween('tgl_masuk', [$tanggalMulai, $tanggalSelesai]);
        }

        if($tanggalMulai !== null && $tanggalSelesai !== null){
            $data = $produkMasuk->get();
        }else{
            $data = ProdukMasuk::all();
        }

        $pdf  = new Dompdf();
        $html = view('/laporan-produk-masuk/print-produk-masuk', compact('data', 'tanggalMulai', 'tanggalSelesai'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('print-produk-masuk.pdf', ['Attachment' => false]);
    }
}
