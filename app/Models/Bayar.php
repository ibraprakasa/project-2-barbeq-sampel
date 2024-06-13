<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bayar extends Model
{
    use HasFactory;

    protected $fillable = [
        'cara_bayar',
        'gambar',
        'pesanan_id',
    ];


    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
