<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "kategoris";
    protected $fillable = [
        'kode',
       'kategori',
        'user_id',


    ];


    public function produk()
    {
        return $this->hasMany(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


      //user ->oleh laravel user_id, ganti author_id
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
