<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; }
        .transaksi { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .badge { background: green; color: white; padding: 5px 10px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #ddd; padding: 8px; text-align: left; }
        a { text-decoration: none; background: #007bff; color: white; padding: 10px 15px; border-radius: 5px; }
    </style>
</head>
<body>
   <div class="container">
    <h2>Riwayat Transaksi</h2>
    <a href="/" style="background: #007bff; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">← Kembali ke Kasir</a>
    <a href="/laporan" style="background: #007bff; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">← LAPORAN</a>
    <hr>

    @forelse($transaksis as $trx)
    <div class="transaksi" style="border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:8px;">

        <div class="header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">

            {{-- KIRI: Info Transaksi --}}
            <div>
                <b>No. Transaksi: #{{ $trx->id }}</b><br>
                Meja: {{ $trx->meja->nama_meja ?? 'Take Away' }}<br>
                Customer: <b style="color:#007bff">{{ $trx->nama_customer ?? '-' }}</b><br>
                Tanggal: {{ $trx->created_at->format('d-m-Y H:i') }}
            </div>

            {{-- TENGAH: Tombol Aksi --}}
            <div>
                <a href="/dashboard" style="background:#007bff; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">Dashboard</a>
                <a href="/cetak/{{ $trx->id }}" target="_blank" style="background:orange; color:white; padding:8px 12px; border-radius:5px; text-decoration:none;">Cetak</a>

                @if($trx->status == 'lunas')
                <form action="/batal/{{ $trx->id }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin mau batalin transaksi ini?')"
                        style="background:red; color:white; border:none; padding:8px 12px; border-radius:5px; cursor:pointer;">
                        Batal
                    </button>
                </form>
                @endif
            </div>

            {{-- KANAN: Badge + Total --}}
            <div style="text-align:right;">
                <span class="badge" style="background:green; color:white; padding:5px 10px; border-radius:5px;">{{ ucfirst($trx->status) }}</span> <br>
                <b>Total: Rp{{ number_format($trx->total) }}</b>
            </div>

        </div>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f2f2f2;">
                    <th style="padding:8px; border:1px solid #ddd;">Menu</th>
                    <th style="padding:8px; border:1px solid #ddd;">Jumlah</th>
                    <th style="padding:8px; border:1px solid #ddd;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trx->detailTransaksi as $detail)
                <tr>
                    <td style="padding:8px; border:1px solid #ddd;">{{ $detail->menu->nama_menu }}</td>
                    <td style="padding:8px; border:1px solid #ddd;">{{ $detail->jumlah }}</td>
                    <td style="padding:8px; border:1px solid #ddd;">Rp{{ number_format($detail->subtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @empty
    <p>Belum ada transaksi</p>
    @endforelse
</div>
</body>
</html>
