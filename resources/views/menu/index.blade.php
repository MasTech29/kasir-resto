<!DOCTYPE html>
<html>
<head>
    <title>Kelola Menu</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ddd; padding: 10px; }
        .btn-tambah { background: green; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kelola Menu</h2>
        <a href="/" style="text-decoration:none;">← Kembali ke Kasir</a> |
        <a href="/menu/tambah" class="btn-tambah">+ Tambah Menu</a>
        <hr>

        @if(session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif
        <table>
    <thead>
        <tr style="background:#f2f2f2;">
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Menu</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($menus as $menu)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if($menu->gambar)
                    <img src="{{ asset('uploads/'.$menu->gambar) }}" width="50" style="border-radius:5px;">
                @else
                    -
                @endif
            </td>
            <td>{{ $menu->nama_menu }}</td>
            <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
            <td>Rp{{ number_format($menu->harga) }}</td>
            <td>
                <a href="/menu/edit/{{ $menu->id }}" style="background:blue; color:white; padding:5px 10px; text-decoration:none; border-radius:3px;">Edit</a>
                <a href="/menu/hapus/{{ $menu->id }}" onclick="return confirm('Yakin mau hapus menu ini?')" style="background:red; color:white; padding:5px 10px; text-decoration:none; border-radius:3px;">Hapus</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">Belum ada menu</td>
        </tr>
        @endforelse
    </tbody>
</table>

            </div>
</body>
</html>
