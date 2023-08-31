<?php

namespace App\Http\Controllers;

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
        return view('biaya-operasional.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getDataBiayaOperasional()
    {
        return response()->json([
            'success' => true,
            'data'    => BiayaOperasional::orderBy('id', 'DESC')->get()
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
            'rentang'       => 'required',
        ], [
            'operasional.required'   => 'Operasional Tidak Boleh Kosong !',
            'biaya.required'         => 'Biaya Tidak Boleh Kosong !',
            'rentang.required'       => 'Rentang Tidak Boleh Kosong !',
            'rentang.numeric'        => 'Hanya Tupe Number Yang Diijinkan'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $operasional = BiayaOperasional::create([
            'operasional'   => $request->operasional,
            'biaya'         => $request->biaya,
            'rentang'       => $request->rentang,
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
            'message'   => 'Edit Data Produk',
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
            'rentang'       => 'required',
        ], [
            'operasional.required'   => 'Operasional Tidak Boleh Kosong !',
            'biaya.required'         => 'Biaya Tidak Boleh Kosong !',
            'rentang.required'       => 'Rentang Tidak Boleh Kosong !',
            'rentang.numeric'        => 'Hanya Tupe Number Yang Diijinkan'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $operasional->update([
            'operasional'   => $request->operasional,
            'biaya'         => $request->biaya,
            'rentang'       => $request->rentang,
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
    public function destroy(string $id)
    {
        //
    }
}
