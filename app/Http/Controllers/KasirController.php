<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $menus = \App\Models\Menu::all();
        $mejas = Meja::all();
        return view('kasir.index', compact('menus','mejas'));
    }

    public function simpanPesanan(Request $request)
    {
        try {
            DB::beginTransaction();

            $total = 0;
            foreach($request->keranjang as $k){
                $total = $total + ($k['harga'] * $k['jumlah']);
            }

           $trx = Transaksi::create([
             'meja_id' => $request->meja_id,
                'nama_customer' => $request->nama_customer,
                'total' => $total,
                'status' => 'lunas'
            ]);

            foreach($request->keranjang as $item){
                DetailTransaksi::create([
                    'transaksi_id' => $trx->id,
                    'menu_id' => $item['id'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga'] * $item['jumlah']
                ]);
            }

            Meja::where('id', $request->meja_id)->update(['status'=>'terpakai']);

            DB::commit();
            return response()->json(['success'=>true, 'id'=>$trx->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false, 'message'=>$e->getMessage()], 500);
        }
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::with('details.menu','meja')->findOrFail($id);
        return view('kasir.cetak', compact('transaksi'));
    }
}
