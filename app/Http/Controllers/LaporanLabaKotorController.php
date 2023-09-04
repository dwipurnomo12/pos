<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Kas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanLabaKotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-laba-kotor.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getLaporanLabaKotor(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
  
        $labaKotor = Kas::query();

        if($tanggalMulai && $tanggalSelesai){
            $labaKotor->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }
        
        $data = $labaKotor->get();

        if(empty($tanggalMulai) && empty($tanggalSelesai)){
            $data = Kas::all();
        }

        foreach ($data as $item) {
            $item->labaKotor = $item->pemasukan - $item->pengeluaran;
        }

        return response()->json($data);
    }

    
     /**
     * Display a Print Laba Kotor
     */
    public function printLabaKotor(Request $request)
    {
        $tanggalMulai   = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');
  
        $labaKotor = Kas::query();

        if($tanggalMulai && $tanggalSelesai){
            $labaKotor->whereBetween('tanggal', [$tanggalMulai, $tanggalSelesai]);
        }
        
        if($tanggalMulai !== null && $tanggalSelesai !== null){
            $data = $labaKotor->get();
        } else {
            $data = Kas::all();
        }

        foreach ($data as $item) {
            $item->labaKotor = $item->pemasukan - $item->pengeluaran;
        }

        $pdf = new Dompdf();
        $html = view('laporan-laba-kotor/print-laba-kotor', compact('data', 'tanggalMulai', 'tanggalSelesai'));
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        $pdf->stream('print-laba-kotor.pdf', ['Attachment' => false]);
    }

}
