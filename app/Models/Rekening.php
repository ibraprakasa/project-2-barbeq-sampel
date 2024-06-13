<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bank',
        'no_rek',
        'nama_pemilik',
        'user_id', // tambahkan kolom user_id
        'pesanan_id', // tambahkan kolom user_id
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }


    public function author()
    {
        //Post ke Categories Relasi satu ke satu
        return $this->belongsTo(User::class,'user_id');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
