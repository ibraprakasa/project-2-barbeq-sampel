<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = "banners";
    protected $fillable = [

        'gambar',
        'detail',    ];


    public function author()
    {
       
        return $this->belongsTo(User::class,'user_id');
    }

    public function getRouteKeyName()
    {
        return 'kode';
    }
}
