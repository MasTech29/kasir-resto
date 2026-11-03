<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MejaMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Bikin 5 Meja - pakai Query Builder biar gak bentrok
        DB::table('mejas')->insert([
            ['nomor_meja' => 'Meja 1'],
            ['nomor_meja' => 'Meja 2'],
            ['nomor_meja' => 'Meja 3'],
            ['nomor_meja' => 'Meja 4'],
            ['nomor_meja' => 'Meja 5'],
        ]);

        // Bikin Kategori
        DB::table('kategoris')->insert([
            ['nama' => 'Makanan'],
            ['nama' => 'Minuman'],
        ]);

        // Ambil ID Kategori
        $makanan = DB::table('kategoris')->where('nama', 'Makanan')->first()->id;
        $minuman = DB::table('kategoris')->where('nama', 'Minuman')->first()->id;

        // Bikin Menu
        DB::table('menus')->insert([
            ['nama' => 'Nasi Goreng', 'harga' => 15000, 'kategori_id' => $makanan],
            ['nama' => 'Ayam Geprek', 'harga' => 18000, 'kategori_id' => $makanan],
            ['nama' => 'Es Teh', 'harga' => 5000, 'kategori_id' => $minuman],
            ['nama' => 'Es Jeruk', 'harga' => 6000, 'kategori_id' => $minuman],
        ]);
    }
}
