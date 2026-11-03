<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; max-width: 500px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: blue; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Menu - {{ $menu->nama_menu }}</h2>
        <a href="/menu" style="text-decoration:none;">← Kembali ke Kelola Menu</a>
        <hr>

        <form action="/menu/update/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama Menu</label>
            <input type="text" name="nama_menu" value="{{ $menu->nama_menu }}" required>

            <label>Harga</label>
            <input type="number" name="harga" value="{{ $menu->harga }}" required>

            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="1" {{ $menu->kategori_id == 1 ? 'selected' : '' }}>Makanan</option>
                <option value="2" {{ $menu->kategori_id == 2 ? 'selected' : '' }}>Minuman</option>
            </select>

            <label>Gambar Saat Ini</label><br>
            @if($menu->gambar)
                <img src="{{ asset('uploads/'.$menu->gambar) }}" width="120" style="border-radius:5px; margin-bottom:10px;"><br>
            @else
                <p><i>Belum ada gambar</i></p>
            @endif

            <label>Ganti Gambar (optional)</label>
            <input type="file" name="gambar">

            <button type="submit">Update Menu</button>
        </form>
    </div>
</body>
</html>
