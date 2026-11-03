<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
{
    // Data Meja
    \DB::table('mejas')->insert([
        ['nama_meja' => 'Meja 1'],
        ['nama_meja' => 'Meja 2'],
        ['nama_meja' => 'Meja 3'],
        ['nama_meja' => 'Meja 4'],
        ['nama_meja' => 'Take Away'],
    ]);

    // Data Kategori
    $kat1 = \DB::table('kategoris')->insertGetId(['nama_kategori' => 'Makanan']);
    $kat2 = \DB::table('kategoris')->insertGetId(['nama_kategori' => 'Minuman']);

    // Data Menu
    \DB::table('menus')->insert([
        ['kategori_id' => $kat1, 'nama_menu' => 'Nasi Goreng', 'harga' => 15000],
        ['kategori_id' => $kat1, 'nama_menu' => 'Ayam Geprek', 'harga' => 18000],
        ['kategori_id' => $kat2, 'nama_menu' => 'Es Teh', 'harga' => 5000],
        ['kategori_id' => $kat2, 'nama_menu' => 'Es Jeruk', 'harga' => 7000],
    ]);
}
}
