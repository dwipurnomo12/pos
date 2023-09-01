<?php

namespace App\Http\Controllers;

use App\Models\Rentang;
use Illuminate\Http\Request;
use App\Models\BiayaOperasional;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BiayaOperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('biaya-operasional.index',  [
            'rentangs'   => Rentang::all()
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataBiayaOperasional()
    {
        return response()->json([
            'success' => true,
            'data'    => BiayaOperasional::with('rentang')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('biaya-operasional.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operasional'   => 'required',
            'biaya'         => 'required|numeric',
            'rentang_id'       => 'required',
        ], [
            'operasional.required'   => 'Operasional Tidak Boleh Kosong !',
            'biaya.required'         => 'Biaya Tidak Boleh Kosong !',
            'rentang_id.required'    => 'Rentang Bayar Tidak Boleh Kosong !',
            'biaya.numeric'          => 'Hanya Tipe Number Yang Diijinkan'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $operasional = BiayaOperasional::create([
            'operasional'   => $request->operasional,
            'biaya'         => $request->biaya,
            'rentang_id'    => $request->rentang_id,
            'user_id'       => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan',
            'data'      => $operasional
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $operasional = BiayaOperasional::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Biaya Operasional',
            'data'      => $operasional
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $operasional = BiayaOperasional::find($id);
        $validator = Validator::make($request->all(), [
            'operasional'   => 'required',
            'biaya'         => 'required|numeric',
            'rentang_id'    => 'required',
        ], [
            'operasional.required'   => 'Operasional Tidak Boleh Kosong !',
            'biaya.required'         => 'Biaya Tidak Boleh Kosong !',
            'rentang_id.required'    => 'Rentang Bayar Tidak Boleh Kosong !',
            'biaya.numeric'          => 'Hanya Tupe Number Yang Diijinkan'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $operasional->update([
            'operasional'   => $request->operasional,
            'biaya'         => $request->biaya,
            'rentang_id'    => $request->rentang_id,
            'user_id'       => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $operasional
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BiayaOperasional::find($id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus !'
        ]);
    }

}
