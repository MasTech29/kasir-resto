<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('transaksis');

        if($request->tanggal_mulai && $request->tanggal_selesai){
            $query->whereBetween('created_at', [$request->tanggal_mulai.' 00:00:00', $request->tanggal_selesai.' 23:59:59']);
        }

        $transaksis = (clone $query)->orderBy('created_at','desc')->get();
        $total_pendapatan = (clone $query)->where('status','lunas')->sum('total');
        $total_transaksi = (clone $query)->count();

        // data grafik
        $grafik = (clone $query)->where('status','lunas')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total) as pendapatan'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal','asc')
            ->get();

        // detail menu
        $details = DB::table('detail_transaksis')
            ->join('menus','menus.id','=','detail_transaksis.menu_id')
            ->select('detail_transaksis.*','menus.nama_menu')
            ->get()
            ->groupBy('transaksi_id');

        return view('laporan.index', compact('transaksis','total_pendapatan','total_transaksi','details','grafik'));
    }
   public function export(Request $request)
{
    $query = DB::table('transaksis');
    if($request->tanggal_mulai && $request->tanggal_selesai){
        $query->whereBetween('created_at', [$request->tanggal_mulai.' 00:00:00', $request->tanggal_selesai.' 23:59:59']);
    }
    $transaksis = $query->orderBy('created_at','desc')->get();

    $fileName = 'laporan-'.date('d-m-Y').'.csv';

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
    ];

    $callback = function() use ($transaksis) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['No','Tanggal','ID Transaksi','Meja','Total','Status']);
        foreach($transaksis as $i => $t){
            fputcsv($file, [
                $i+1,
                date('d/m/Y H:i', strtotime($t->created_at)),
                '#'.$t->id,
                'Meja '.$t->meja_id,
                $t->total,
                $t->status
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
