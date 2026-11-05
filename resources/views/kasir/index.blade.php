<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Resto</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('favicon.jpg') }}?v=99">
<link rel="icon" type="image/jpg" href="{{ asset('favicon.jpg') }}?v=99">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 p-3 md:p-5">

<!-- HEADER CLEAN 1x DOANG -->
<div class="bg-white p-3 rounded-lg shadow mb-4">
    <div class="flex justify-between items-center">
        <h1 class="font-black text-lg md:text-xl">KASIR RESTO - {{ Session::get('username') }}</h1>
        <div class="flex items-center gap-2">
            <div class="text-right hidden md:block">
                <p class="text-[10px] text-gray-500 uppercase">Login sebagai</p>
                @if(Session::get('role') == 'admin')
                    <span class="bg-red-500 text-white text-[10px] px-2 py-1 rounded font-bold">BOS / ADMIN</span>
                @else
                    <span class="bg-blue-500 text-white text-[10px] px-2 py-1 rounded font-bold">KASIR</span>
                @endif
            </div>
            <a href="/logout" class="bg-gray-800 text-white px-3 py-2 rounded text-sm">🚪 Logout</a>
        </div>
    </div>

    <!-- TOMBOL MENU -->
    <div class="mt-3 flex flex-wrap gap-2">
        <a href="/riwayat" class="bg-blue-500 text-white px-3 py-2 rounded text-sm">Riwayat</a>
        @if(Session::get('role') == 'admin')
            <a href="/dashboard" class="bg-purple-500 text-white px-3 py-2 rounded text-sm">Dashboard</a>
            <a href="/menu" class="bg-yellow-400 text-black px-3 py-2 rounded text-sm font-bold">Kelola Menu</a>
            <a href="/laporan" class="bg-green-600 text-white px-3 py-2 rounded text-sm">📊 Laporan</a>
        @endif
    </div>
</div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white p-4 rounded-lg shadow">
            <h2 class="font-bold text-xl mb-3">1. Pesanan Untuk</h2>
            <div class="flex gap-2 mb-5 bg-gray-50 p-3 rounded-lg border">
                <div class="flex-1">
                    <label class="text-[11px] font-bold text-gray-500 uppercase">Nama Customer</label>
                    <input type="text" id="nama_customer" class="border p-2 w-full rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" placeholder="Contoh: risa">
                </div>
                <div class="w-36">
                    <label class="text-[11px] font-bold text-gray-500 uppercase">Meja</label>
                    <select id="meja" class="border p-2 w-full rounded-lg text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        @foreach($mejas as $meja)
                        <option value="{{ $meja->id }}">{{ $meja->nama_meja }} - {{ $meja->status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h2 class="font-bold text-xl mb-2">2. Pilih Menu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($menus as $menu)
                <div class="border p-3 rounded-lg hover:shadow-md transition bg-white">
                    <p class="font-semibold">{{ $menu->nama_menu }}</p>
                    <p class="text-sm text-gray-500">{{ $menu->kategori->nama_kategori }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="font-bold text-green-600">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                        <button
                            data-id="{{ $menu->id }}"
                            data-nama="{{ $menu->nama_menu }}"
                            data-harga="{{ $menu->harga }}"
                            class="btn-tambah bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                            + Tambah
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- KOLOM KANAN: KERANJANG -->
        <div class="bg-white p-4 rounded-lg shadow sticky top-5 h-fit">
            <h2 class="font-bold text-xl mb-2">Keranjang</h2>
            <div id="keranjang" class="min-h-[100px]">
                <p class="text-gray-400">Belum ada pesanan</p>
            </div>
            <hr class="my-3">
            <p class="font-bold text-lg">Total: Rp<span id="total">0</span></p>
            <button onclick="bayar()" class="bg-blue-500 text-white w-full py-2 mt-3 rounded hover:bg-blue-600 font-bold">
                Bayar & Cetak
            </button>
        </div>
    </div>

<script>
    let keranjang = [];
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('btn-tambah')) {
            let id = e.target.dataset.id;
            let nama = e.target.dataset.nama;
            let harga = parseInt(e.target.dataset.harga);
            tambahKeKeranjang(id, nama, harga);
        }
    });
    function tambahKeKeranjang(id, nama, harga) {
        let item = keranjang.find(i => i.id == id);
        if(item) {
            item.jumlah++;
        } else {
            keranjang.push({id, nama, harga, jumlah: 1});
        }
        tampilkanKeranjang();
    }
    function tampilkanKeranjang() {
        let html = '';
        let total = 0;
        keranjang.forEach(item => {
            total += item.harga * item.jumlah;
            html += `
                <div class="flex justify-between border-b py-2">
                    <div>
                        <p class="font-semibold">${item.nama}</p>
                        <p class="text-sm">x${item.jumlah} @ Rp${item.harga.toLocaleString('id-ID')}</p>
                    </div>
                    <span class="font-bold">Rp${(item.harga * item.jumlah).toLocaleString('id-ID')}</span>
                </div>
            `;
        });
        document.getElementById('keranjang').innerHTML = html || '<p class="text-gray-400">Belum ada pesanan</p>';
        document.getElementById('total').innerText = total.toLocaleString('id-ID');
    }
function bayar() {
    let meja_id = document.getElementById('meja').value;
    let nama_customer = document.getElementById('nama_customer').value;
    if(keranjang.length == 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    if(nama_customer == "") {
        alert('Isi nama customer dulu!');
        document.getElementById('nama_customer').focus();
        return;
    }
    fetch('/simpan-pesanan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            meja_id: meja_id,
            nama_customer: nama_customer,
            keranjang: keranjang
        })
    })
  .then(res => res.json())
  .then(data => {
        if(data.success){
            window.location.href = '/cetak/' + data.id;
        } else {
            alert('Gagal: ' + data.message);
        }
    })
  .catch(err => alert(err));
}
</script>
<footer style="text-align:center; padding:15px; margin-top:40px; border-top:1px solid #eee; color:#888; font-size:13px;">
    &copy; {{ date('Y') }} Kasir Resto - Dibuat oleh <b>MASTECH Versi 1.0</b>. All Rights Reserved.
</footer>
</body>
</html>
