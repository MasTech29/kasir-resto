<!DOCTYPE html>
<html>
<head><title>Nota #{{ $transaksi->id }}</title>
<style>
body{font-family: monospace; font-size: 11px; width: 58mm; margin:auto; padding:5px}
.center{text-align:center} .right{text-align:right} hr{border:1px dashed #000; margin:5px 0}
</style>
</head>
<body onload="window.print()">
<div class="center">
<b>KASIR RESTO</b><br>
Jl. SRIAMUR KECAMATAN TAMBUN UTARA<br>
Telp: 0812-3456-7890<br>
</div>
<hr>
No Nota  : #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}<br>
Tanggal  : {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') }}<br>
Kasir    : {{ session('username') ?? 'admin' }}<br>
Meja     : {{ $transaksi->meja_id }}<br>
Customer : <b>{{ $transaksi->nama_customer }}</b><br>
<hr>

@foreach($details as $d)
<b>{{ $d->nama_menu }}</b><br>
{{ $d->jumlah }} x Rp{{ number_format($d->harga_menu,0,',','.') }}
<span style="float:right">Rp{{ number_format($d->subtotal,0,',','.') }}</span><br><br>
@endforeach

<hr>
Subtotal <span style="float:right">Rp{{ number_format($transaksi->total,0,',','.') }}</span><br>
<b>TOTAL <span style="float:right">Rp{{ number_format($transaksi->total,0,',','.') }}</span></b><br>
Tunai <span style="float:right">Rp{{ number_format($transaksi->total,0,',','.') }}</span><br>
Kembali <span style="float:right">Rp0</span><br>
<hr>
<div class="center">
~ QRIS PEMBAYARAN ~<br>
<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KASIRRESTO-{{ $transaksi->id }}" style="width:120px; margin:5px"><br>
Scan untuk Bayar Digital<br>
<hr>
Terima Kasih<br>
Atas Nama <b>{{ $transaksi->nama_customer }}</b><br>
Selamat Menikmati!<br><br>
*** Lunas ***<br>
</div>
<!-- TOMBOL BALIK KE KASIR - TIDAK AKAN TERCETAK -->
<style>
    .no-print {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 50px;
    }
    .btn-kasir {
        display: inline-block;
        padding: 12px 25px;
        background-color: #0d6efd;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-family: Arial, sans-serif;
        font-weight: bold;
        margin: 5px;
        border: none;
        cursor: pointer;
    }
    .btn-cetak {
        display: inline-block;
        padding: 12px 25px;
        background-color: #198754;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-family: Arial, sans-serif;
        font-weight: bold;
        margin: 5px;
        border: none;
        cursor: pointer;
    }
    /* INI KUNCINYA: Tombol hilang pas di-print */
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="no-print">
    <a href="{{ url('/') }}" class="btn-kasir">← Balik ke Kasir</a>
    <button onclick="window.print()" class="btn-cetak">🖨️ Cetak Lagi</button>
    <br><br>
    <a href="{{ url('/transaksi') }}" style="color: #666; font-family: Arial; font-size: 14px;">Lihat Daftar Transaksi</a>
</div>

<script>
    // Auto print pas halaman dibuka (optional, kalo mau)
    // window.onload = function() { window.print(); }
</script>
</body>
</html>
