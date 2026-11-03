<!DOCTYPE html>
<html>
<head>
<title>Struk #{{ $transaksi->id }}</title>
<style>
    body { font-family: 'Courier New', monospace; font-size: 11px; width: 58mm; margin: 0 auto; padding: 5px; color: #000; }
    .center { text-align: center; }
    .right { text-align: right; }
    .bold { font-weight: bold; }
    hr { border: none; border-top: 1px dashed #000; margin: 5px 0; }
    table { width: 100%; }
    @media print { body { width: 100%; } }
</style>
</head>
<body onload="window.print()">

<div class="center">
    <span class="bold" style="font-size:14px">KASIR RESTO</span><br>
    Jl. SRIAMUR KECAMATAN TAMBUN UTARA<br>
    Telp: 0812-3456-7890<br>
</div>
<hr>
No Nota : #{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}<br>
Tanggal : {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
Kasir   : {{ session('username') ?? 'admin' }}<br>
Meja    : {{ $transaksi->meja->nama_meja ?? 'Meja '.$transaksi->meja_id }}<br>
Customer: <b>{{ $transaksi->nama_customer }}</b><br>
<hr>

@foreach($transaksi->details ?? $transaksi->detailTransaksi as $d)
{{ $d->menu->nama_menu ?? 'Menu #'.$d->menu_id }}<br>
{{ $d->jumlah }} x {{ number_format($d->menu->harga ?? ($d->subtotal/$d->jumlah),0,',','.') }}
<span class="right" style="float:right">Rp{{ number_format($d->subtotal,0,',','.') }}</span><br>
@endforeach

<hr>
<table>
<tr><td>Subtotal</td><td class="right">Rp{{ number_format($transaksi->total,0,',','.') }}</td></tr>
<tr><td class="bold">TOTAL</td><td class="right bold">Rp{{ number_format($transaksi->total,0,',','.') }}</td></tr>
<tr><td>Tunai</td><td class="right">Rp{{ number_format($transaksi->total,0,',','.') }}</td></tr>
<tr><td>Kembali</td><td class="right">Rp0</td></tr>
</table>
<hr>

<div class="center">
~ QRIS PEMBAYARAN ~<br>
<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KASIRRESTO-{{ $transaksi->id }}-{{ $transaksi->total }}" style="margin:5px; width:120px"><br>
Scan untuk Bayar Digital<br>
<hr>
Terima Kasih<br>
Atas Nama <b>{{ $transaksi->nama_customer }}</b><br>
Selamat Menikmati!<br>
<br>
*** Lunas ***<br>
<b>MAS PROJECT</b>
</div>

</body>
</html>
