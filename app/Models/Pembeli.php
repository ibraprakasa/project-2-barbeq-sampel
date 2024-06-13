<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Pembeli extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_tlp',
        'alamat_pembeli',
        'gambar',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

      protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

}
