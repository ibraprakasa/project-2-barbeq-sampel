<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "wishlists";
    protected $fillable = [

        'nama_product',
        'harga',
        'gambar',
        'id_wish',
        'user_id',
        'penjual_id'



    ];
    public function kategori()
    {
        //Post ke Categories Relasi satu ke satu
        return $this->belongsTo(Kategori::class);

    }
    public function produk()
    {
        return $this->belongsTo(Produk::class,'id_wish');
    }
    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class,'user_id');
    }
}
