<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['meja', 'detailTransaksi.menu'])
                        ->latest()
                        ->get();
        return view('riwayat', compact('transaksis'));
    }

    public function cetak($id){
    if(!session('login')) return redirect('/login');

    $transaksi = \DB::table('transaksis')->where('id', $id)->first();
    $details = \DB::table('detail_transaksis')
    ->join('menus', 'detail_transaksis.menu_id', '=', 'menus.id')
    ->where('transaksi_id', $id)
    ->select('detail_transaksis.*', 'menus.nama_menu', 'menus.harga as harga_menu')
    ->get();
    return view('transaksi.nota', compact('transaksi','details'));
}

public function dashboard(Request $request)
{
    $tanggal = $request->tanggal ?? Carbon::today()->format('Y-m-d');

    $transaksis = Transaksi::with(['meja', 'detailTransaksi.menu'])
                    ->whereDate('created_at', $tanggal)
                    ->latest()
                    ->get();

    $total_penjualan = $transaksis->sum('total');
    $jumlah_transaksi = $transaksis->count();

    return view('dashboard', compact('transaksis', 'total_penjualan', 'jumlah_transaksi', 'tanggal'));
}
public function batal($id)
{
    $trx = Transaksi::findOrFail($id);
    $trx->status = 'batal';
    $trx->save();

    return redirect('/riwayat')->with('success', 'Transaksi berhasil dibatalkan');
}
}
