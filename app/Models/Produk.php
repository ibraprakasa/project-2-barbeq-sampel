<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $with = ['author','kategori'];
    protected $table = "produks";
    protected $fillable = [
        'kode',
        'nama_produk',
        'harga',
        'gambar',
        'detail',
        'stock',
        'kategori_id',
        'user_id',


    ];



    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function author()
    {
        //Post ke Categories Relasi satu ke satu
        return $this->belongsTo(User::class,'user_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getRouteKeyName()
    {
        return 'kode';
    }
}
