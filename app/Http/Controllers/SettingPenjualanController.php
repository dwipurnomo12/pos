<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SettingPenjualan;
use App\Http\Controllers\Controller;

class SettingPenjualanController extends Controller
{
    public function index()
    {
        $settingPenjualan = SettingPenjualan::first();
        return view('setting-penjualan.index', [
            'settingPenjualan'  => $settingPenjualan
        ]);
    }

    public function updateDiskon(Request $request)
    {
        $settingPenjualan = SettingPenjualan::first();
        $settingPenjualan->update([
            'diskon_enabled'    => $request->input('diskon_enabled', false),
            'diskon_presentase' => $request->input('diskon_presentase', 0),
            'ppn_enabled'       => $request->input('ppn_enabled', false),
            'ppn_presentase'    => $request->input('ppn_presentase', 0),
        ]);


        return response()->json(['message' => 'Pengaturan berhasil diperbarui']);
    }

    public function updatePpn(Request $request)
    {
        $settingPenjualan = SettingPenjualan::first();
        $settingPenjualan->update([
            'ppn_enabled'       => $request->input('ppn_enabled', false),
            'ppn_presentase'    => $request->input('ppn_presentase', 0),
        ]);


        return response()->json(['message' => 'Pengaturan berhasil diperbarui']);
    }
}
