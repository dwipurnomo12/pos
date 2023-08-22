<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukKeluarController;
use App\Http\Controllers\ProdukMasukController;
use App\Http\Controllers\SettingPenjualanController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/produk/get-data', [ProdukController::class, 'getDataProduk']);
Route::resource('/produk', ProdukController::class);

Route::get('/kategori/get-data', [KategoriController::class, 'getDataKategori']);
Route::resource('/kategori', KategoriController::class);

Route::get('/supplier/get-data', [SupplierController::class, 'getDataSupplier']);
Route::resource('/supplier', SupplierController::class);

Route::get('/satuan/get-data', [SatuanController::class, 'getDataSatuan']);
Route::resource('/satuan', SatuanController::class);

Route::get('/produk-masuk/get-data', [ProdukMasukController::class, 'getDataProdukMasuk']);
Route::get('/api/produk-masuk', [ProdukMasukController::class, 'getAutoCompleteData']);
Route::resource('/produk-masuk', ProdukMasukController::class);

Route::get('/produk-keluar/get-data', [ProdukKeluarController::class, 'getDataProdukKeluar']);
Route::get('/api/produk-keluar', [ProdukKeluarController::class, 'getAutoCompleteData']);
Route::resource('/produk-keluar', ProdukKeluarController::class);

Route::get('/api/menu-penjualan', [PenjualanController::class, 'getAutoCompleteData']);
Route::resource('/menu-penjualan', PenjualanController::class);

Route::get('/setting-penjualan', [SettingPenjualanController::class, 'index']);
Route::post('/setting-penjualan/update-diskon', [SettingPenjualanController::class, 'updateDiskon']);
Route::post('/setting-penjualan/update-ppn', [SettingPenjualanController::class, 'updatePpn']);