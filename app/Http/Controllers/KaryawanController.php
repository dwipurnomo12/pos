<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('karyawan.index', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Display a Fetch Data
     */
    public function getDataKaryawan()
    {
        return response()->json([
            'success' => true,
            'data'    => User::with('role')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required',
            'password'  => 'required|min:4',
            'role_id'   => 'required'
        ], [
            'name.required'     => 'Form Nama Wajib Di isi !',
            'email.required'    => 'Form Email Wajib Di isi !',
            'password.required' => 'Form Password Wajib Di isi !',
            'password.min'      => 'Password Minimal 4 Huruf/Angka/Karakter !',
            'role_id.required'  => 'Tentukan Role/Hak Akses !',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $karyawan = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => $request->role_id
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Disimpan !',
            'data'      => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $karyawan = User::find($id);
        return response()->json([
            'success'   => true,
            'message'   => 'Edit Data Produk',
            'data'      => $karyawan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $karyawan   = User::find($id);
        $validator  = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required',
            'role_id'   => 'required'
        ], [
            'name.required'     => 'Form Nama Wajib Di isi !',
            'email.required'    => 'Form Email Wajib Di isi !',
            'role_id.required'  => 'Tentukan Role/Hak Akses !',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $karyawanEdit = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
        ];

        if(!empty($request->password)){
            $validatorPassword = Validator::make($request->all(), [
                'password'   => 'min:4'
            ], [
                'password.min' => 'Password Minimal 4 Huruf/Angka/Karakter'
            ]);
      
            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $karyawanEdit['password'] = Hash::make($request->password);
        }

        $karyawan->update($karyawanEdit);

        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Terupdate',
            'data'      => $karyawan
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return response()->json([
            'success'   => true,
            'message'   => 'Data Berhasil Dihapus !'
        ]);
    }
}
