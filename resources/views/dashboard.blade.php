<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; }
        .card { background: #007bff; color: white; padding: 20px; border-radius: 8px; display: inline-block; width: 200px; margin-right: 10px; }
        .card h3 { margin: 0; font-size: 14px; }
        .card h1 { margin: 10px 0 0 0; }
        form { margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ddd; padding: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Dashboard Penjualan</h2>
        <a href="/">← Kasir</a> | <a href="/riwayat">Riwayat</a>
        <hr>

        <div class="card">
            <h3>Total Penjualan</h3>
            <h1>Rp{{ number_format($total_penjualan) }}</h1>
        </div>
        <div class="card" style="background:green">
            <h3>Jumlah Transaksi</h3>
            <h1>{{ $jumlah_transaksi }}</h1>
        </div>

        <form method="GET" action="/dashboard">
            <label>Pilih Tanggal: </label>
            <input type="date" name="tanggal" value="{{ $tanggal }}">
            <button type="submit">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th><th>Meja</th><th>Total</th><th>Waktu</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $trx)
                <tr>
                    <td>#{{ $trx->id }}</td>
                    <td>{{ $trx->meja->nama_meja ?? 'Take Away' }}</td>
                    <td>Rp{{ number_format($trx->total) }}</td>
                    <td>{{ $trx->created_at->format('H:i') }}</td>
                    <td><a href="/cetak/{{ $trx->id }}" target="_blank">Cetak</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
