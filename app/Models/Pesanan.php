<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = [
        'gambar',
        'gambar2',
        'gambar3',
        'harga',
        'alamat',
        'jumlah_produk',
        'pembeli_id',
        'produk_id',
        'user_id',
        'bukti_transfer',
        'statusverifikasi_id',
        'status_id',
        'rekening_id',
        'bayar_id',
        'keuangan_id',
        'expedisi_id',

    ];

    public function expedisi()
    {
        return $this->belongsTo(Expedisi::class);
    }
    public function statusverifikasi()
    {
        return $this->belongsTo(Statusverifikasi::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function bayar()
    {
        return $this->belongsTo(Bayar::class);
    }


    public function rekening()
    {
        return $this->belongsTo(Rekening::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
