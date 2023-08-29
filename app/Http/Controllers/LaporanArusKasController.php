<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\ProdukMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class LaporanArusKasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laporan-arus-kas.index', [
            'arusKas'   => Kas::all()
        ]);
    }


}