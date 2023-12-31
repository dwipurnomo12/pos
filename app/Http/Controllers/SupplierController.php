<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
    }

        /**
     * Display a Fetch Data
     */
    public function getDataSupplier()
    {
        return response()->json([
            'success' => true,
            'data'    => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier'  => 'required',
            'alamat'    => 'required'
        ],[
            'supplier.required' => 'Form Supplier Tidak Bolek Kosong',
            'alamat.required'   => 'Form Alamat Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $supplier = Supplier::create([
            'supplier'  => $request->supplier,
            'alamat'    => $request->alamat,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $supplier
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Supplier',
            'data'      => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $validator = Validator::make($request->all(), [
            'supplier'  => 'required',
            'alamat'    => 'required'
        ],[
            'supplier.required' => 'Form Supplier Tidak Bolek Kosong',
            'alamat.required'   => 'Form Alamat Tidak Boleh Kosong'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $supplier->update([
            'supplier'  => $request->supplier,
            'alamat'    => $request->alamat,
            'user_id'   => auth()->user()->id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $supplier
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Supplier::find($id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus'
        ]);
    }
}
