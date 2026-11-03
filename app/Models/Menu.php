<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['nama_menu', 'harga','kategori_id','gambar'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'kategori_id');
    }
    public function detailTransaksi()
{
    return $this->hasMany(DetailTransaksi::class);
}
}
