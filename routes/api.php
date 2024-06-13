

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CartController; // Perbaikan 2: Mengimpor CartController
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\TransaksiController;
use App\Models\Pembeli;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/Pembeli', function (Request $request) {
    return $request->pembeli();
});

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);

Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("refresh", [ApiController::class, "refreshToken"]);
    Route::get("logout", [ApiController::class, "logout"]);
});

Route::get("/get", [ProdukController::class, "fetch"]);
Route::post('produk', [ProdukController::class, "store"]);
Route::put('produk/{id}', [ProdukController::class, "update"]);
Route::get('produk', [ProdukController::class, "index"]);

Route::get('wishlist', [WishlistController::class, "index"]);
Route::post('wishlist', [WishlistController::class, "store"]);
Route::put('wishlist/{id}', [WishlistController::class, "update"]);

Route::get('kategori', [KategoriController::class, "index"]);

Route::get("/get", [ProdukController::class, "fetch"]);

Route::get("/get", [CartController::class, "fetch"]);
Route::post('cart', [CartController::class, "store"]); // Perbaikan 4: Menggunakan CartController
Route::put('cart/{id}', [CartController::class, "update"]); // Jika ada endpoint update
Route::get('cart', [CartController::class, "index"]);

Route::get('user', [UserProfileController::class, "index"]);
Route::put('user/{id}', [UserProfileController::class, "update"]);



Route::get("/get", [TransaksiController::class, "fetch"]);
Route::post('transaksi', [TransaksiController::class, "store"]);
Route::put('transaksi/{id}', [TransaksiController::class, "update"]);
Route::get('transaksi',[TransaksiController::class, "index"]);




Route::get("/get", [PromoController::class, "fetch"]);
Route::post('promo', [PromoController::class, "store"]);
Route::put('promo/{id}', [PromoController::class, "update"]);
Route::get('promo',[PromoController::class, "index"]);
