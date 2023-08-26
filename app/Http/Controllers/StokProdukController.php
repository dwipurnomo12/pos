<?php

namespace App\Http\Controllers;

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
}
