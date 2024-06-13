<?php

use App\Models\User;
use App\Models\Bayar;
use App\Models\Produk;
use App\Models\Kategori;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllController;
use App\Http\Controllers\AllkategoriController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BayarController;
use App\Http\Controllers\CategoriController;
use App\Http\Controllers\ExpedisiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\SetoradminController;
use App\Http\Controllers\UserController; // tambahkan ini untuk UserController
use App\Models\Pembeli;

/*
|--------------------------------   ------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home',['title'=>'Home Pages', 'active' => 'home']);
});

Route::get('/dashboard', function () {
    return view('dashboard.index',['title' => 'Dashboard']);
})->middleware('auth'); // untuk proteksi

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest'); // untuk menampilkan form
Route::post('/login', [LoginController::class, 'authenticate']); // memproses form
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::resource('pembeli', PembeliController::class)->except('show');
    Route::get('pembeli/{id}', [PembeliController::class, 'show'])->name('pembeli.show');
});

Route::resource('/pengiriman', PengirimanController::class)->except('show')->middleware('auth');
Route::get('/pengiriman/{id}', [PengirimanController::class, 'show'])->name('pengiriman.show');




Route::get('/all', [AllController::class, 'index'])->name('all.index');
Route::put('/all/{id}/update-statusverifikasi', [AllController::class, 'updateStatusverifikasi'])->name('all.updateStatusverifikasi');
Route::put('/all/{id}/update-status', [AllController::class, 'updateStatus'])->name('all.updateStatus');
Route::delete('/all/{id}', [AllController::class, 'destroy'])->name('all.destroy');
Route::get('/all/{id}', [AllController::class, 'show'])->name('all.show');

Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
Route::put('/keuangan/{id}/update', [KeuanganController::class, 'update'])->name('keuangan.update');
Route::delete('/keuangan/{id}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
Route::get('/keuangan/{id}/edit', [KeuanganController::class, 'edit'])->name('keuangan.edit');
Route::get('/keuangan/{id}', [KeuanganController::class, 'show'])->name('keuangan.show');


Route::resource('/kategori', KategoriController::class)->except('show');
Route::resource('/expedisi', ExpedisiController::class)->except('show');
Route::resource('/bayar', BayarController::class)->except('show');
Route::resource('/categori', CategoriController::class)->except('show');

// Route::group(['middleware' => ['auth', 'superadmin']], function () {
//     Route::get('/user', [UserController::class, 'manageUsers'])->name('user.manage');
// });
Route::put('/pengiriman/{id}/update-status', [PengirimanController::class, 'updateStatus'])->name('pengiriman.updateStatus');
Route::put('/pesanan/{id}/update-statusverifikasi', [PesananController::class, 'updateStatusverifikasi'])->name('pesanan.updateStatusverifikasi');
Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
Route::resource('/pesanan', PesananController::class)->except('show')->middleware('auth');



Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.manage');
       Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy'); // Perbaikan di sini
    Route::post('/user', [UserController::class, 'store'])->name('user.store'); // Perbaikan di sini
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/create', [ProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');
    Route::get('/profil/edit/{id}', [ProfilController::class, 'edit'])->name('profil.edit'); // Tambahkan definisi route edit
    Route::put('/profil/update/{id}', [ProfilController::class, 'update'])->name('profil.update');

});

// Rute untuk admin
Route::middleware(['auth'])->group(function () {
    Route::resource('/penjual', PenjualController::class)->except('show');
    Route::get('/penjual/{id}', [PenjualController::class, 'show'])->name('penjual.show');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('/produk', ProdukController::class)->except('show');
    Route::get('/produk/{produk}', [ProdukController::class, 'show'])->name('produk.show');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('/banner', BannerController::class)->except('show');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/rekening', [RekeningController::class, 'index'])->name('rekening.index');
    Route::get('/rekening/create', [RekeningController::class, 'create'])->name('rekening.create');
    Route::post('/rekening/store', [RekeningController::class, 'store'])->name('rekening.store');
    Route::get('/rekening/{rekening}/edit', [RekeningController::class, 'edit'])->name('rekening.edit'); // Definisi route untuk halaman edit
    Route::put('/rekening/{rekening}', [RekeningController::class, 'update'])->name('rekening.update');
    Route::delete('/rekening/{rekening}', [RekeningController::class, 'destroy'])->name('rekening.destroy');
});




?>
