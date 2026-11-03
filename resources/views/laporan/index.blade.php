<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body{font-family:Arial;padding:20px;background:#f4f4f4}
        .card{background:white;padding:20px;border-radius:8px;margin-bottom:20px}
        table{width:100%;border-collapse:collapse;background:white}
        th,td{border:1px solid #ddd;padding:10px}
        th{background:#eee}
        .box2{display:flex;gap:20px;margin-bottom:20px}
        .box{background:white;padding:15px;border-radius:8px;flex:1;border-left:5px solid green}
        button{padding:8px 12px;border:none;border-radius:4px;background:green;color:white}
    </style>
</head>
<body>
<h2>Laporan Penjualan</h2>
<a href="/">← Kasir</a> | <a href="/menu">Menu</a> <hr>

<div class="card">
<form method="GET" action="/laporan">
Dari: <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
Sampai: <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
<button type="submit">Filter</button>
<a href="/laporan" style="background:gray;color:white;padding:8px;text-decoration:none;border-radius:4px">Reset</a>
</form>
</div>

<div class="box2">
<div class="box"><h3>Total Transaksi</h3><h2>{{ $total_transaksi }}</h2></div>
<div class="box" style="border-left-color:blue"><h3>Pendapatan Lunas</h3><h2>Rp{{ number_format($total_pendapatan) }}</h2></div>
</div>

<div class="card"><h3>📈 Grafik Pendapatan</h3><canvas id="grafik" height="100"></canvas></div>

<table>
<tr><th>No</th><th>Tanggal</th><th>ID</th><th>Meja</th><th>Menu</th><th>Total</th><th>Status</th></tr>
@forelse($transaksis as $t)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ date('d/m/Y H:i', strtotime($t->created_at)) }}</td>
<td>#{{ $t->id }}</td>
<td>Meja {{ $t->meja_id }}</td>
<td>
@if(isset($details[$t->id]))
@foreach($details[$t->id] as $d) {{ $d->nama_menu }} ({{ $d->jumlah ?? $d->qty ?? 1 }}x)<br> @endforeach
@else - @endif
</td>
<td>Rp{{ number_format($t->total) }}</td>
<td>{{ $t->status }}</td>
</tr>
@empty
<tr><td colspan="7" style="text-align:center">Kosong</td></tr>
@endforelse
</table>

<br><button onclick="window.print()" style="background:blue">🖨️ Cetak</button>
<a href="/laporan/export?tanggal_mulai={{ request('tanggal_mulai') }}&tanggal_selesai={{ request('tanggal_selesai') }}"
style="background:green;color:white;padding:8px 12px;text-decoration:none;border-radius:4px;margin-left:10px">📥 Export Excel</a>🖨️ Cetak</button>

<script>
new Chart(document.getElementById('grafik'), {
  type: 'line',
  data: {
    labels: [@foreach($grafik as $g)'{{ date('d M', strtotime($g->tanggal)) }}',@endforeach],
    datasets: [{
      label:'Pendapatan',
      data:[@foreach($grafik as $g){{ $g->pendapatan }},@endforeach],
      borderColor:'blue',
      backgroundColor:'rgba(54,162,235,0.3)',
      borderWidth:3,
      fill:true,
      tension:0.4,
      pointBackgroundColor:'blue',
      pointRadius:5
    }]
  },
  options:{
    responsive:true,
    scales:{y:{beginAtZero:true}},
    plugins:{legend:{display:true}}
  }
});
</script>
</body>
</html>
