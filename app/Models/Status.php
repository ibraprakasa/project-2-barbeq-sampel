<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $guarded = ['id'];//tidak boleh manual diisi
    protected $table ='statuss';


   //Relasi tabel users ke posts 1 ke N
   public function pembeli(){
    return $this->hasMany(Pembeli::class);
}

    //user ->oleh laravel user_id, ganti author_id
    public function author()
    {
        //Post ke Categories Relasi satu ke satu
        return $this->belongsTo(User::class,'user_id');
    }

    public function getRouteKeyName()
    {
        return 'kode';
    }
}
