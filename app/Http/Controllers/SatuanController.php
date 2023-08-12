<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('satuan.index');
    }

    /**
     * Display a Fetch Data
     */
    public function getDataSatuan()
    {
        return response()->json([
            'success' => true,
            'data'    => Satuan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('satuan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'satuan'            => 'required'
        ], [
            'satuan.required'   => 'Form Satuan Tidak Boleh Kosong !'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $satuan = Satuan::create([
            'satuan'    => $request->satuan,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $satuan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $satuan = Satuan::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Kategori',
            'data'      => $satuan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);
        $validator = Validator::make($request->all(),[
            'satuan'  => 'required',
        ],[
            'satuan.required' => 'Form Satuan Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $satuan->update([
            'satuan'    => $request->satuan,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $satuan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Satuan::find($id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus'
        ]);
    }
}
