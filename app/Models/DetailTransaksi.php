<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'menu_id', 'jumlah', 'subtotal'];

    // 1 Detail milik 1 Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // 1 Detail milik 1 Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
