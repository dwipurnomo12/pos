<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StokProdukController extends Controller
{
    public function index()
    {
        return view('stok-produk.index');
    }

    public function getDataStok(Request $request)
    {
        $selectedOption = $request->input('opsi');

        if($selectedOption == 'semua'){
             $produks = Produk::all();
        } elseif ($selectedOption == 'minimum'){
             $produks = Produk::where('stok', '<=', 10)->get();
        } elseif ($selectedOption == 'stok-habis'){
             $produks = Produk::where('stok', 0)->get();
        } else {
             $produks = Produk::all();
        }
 
        return response()->json($produks);
    }

    /**
     * Print Stok Produk Report 
    */
    public function printLaporanStok(Request $request)
    {
        $selectedOption = $request->input('opsi');
        $produks = [];

        if($selectedOption == 'semua'){
            $produks = Produk::all();
        } elseif($selectedOption == 'minimum'){
            $produks = Produk::where('stok', '<=', 10 )->get();
        } elseif($selectedOption == 'stok-habis'){
            $produks = Produk::where('stok', 0)->get();
        } 

        $pdf   = new Dompdf();
        $html  = view('/stok-produk/laporan-stok', compact('produks', 'selectedOption'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'langscape');
        $pdf->render();
        $pdf->stream('laporan-stok.pdf', ['Attachment'  => false]);
    }
}
