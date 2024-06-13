<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('gambar')->nullable();
            $table->string('gambar2')->nullable();
            $table->string('gambar3')->nullable();
            $table->integer('harga');
            $table->integer('jumlah_produk');
            $table->string('alamat');
            $table->foreignId('produk_id');
            $table->foreignId('pembeli_id');
            $table->foreignId('user_id');
            $table->foreignId('status_id')->nullable()->default(1);
            $table->foreignId('statusverifikasi_id')->nullable()->default(1);;
            $table->foreignId('rekening_id')->nullable();
            $table->foreignId('bayar_id')->nullable();
            $table->foreignId('expedisi_id')->nullable();
            $table->timestamps();
        });
    }





    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanans');
    }
};
