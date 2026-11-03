<!DOCTYPE html>
<html>
<head>
    <title>Tambah Menu</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; max-width: 500px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: green; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Menu Baru</h2>
        <a href="/menu">← Kembali ke Kelola Menu</a>
        <hr>

        <form action="/menu/simpan" method="POST">
            @csrf

            <label>Nama Menu</label>
            <input type="text" name="nama_menu" placeholder="Contoh: Mie Goreng" required>

            <label>Harga</label>
            <input type="number" name="harga" placeholder="Contoh: 12000" required>

            <label>Kategori</label>
            <select name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="1">Makanan</option>
                <option value="2">Minuman</option>
            </select>

            <button type="submit">Simpan Menu</button>
        </form>
    </div>
</body>
</html>
