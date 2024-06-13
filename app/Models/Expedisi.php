<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedisi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = "expedisis";
    protected $fillable = [
        'expedisi',
        'harga',
    ];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
