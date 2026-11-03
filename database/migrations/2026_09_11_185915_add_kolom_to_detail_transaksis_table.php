<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->foreignId('transaksi_id')->after('id')->constrained('transaksis')->onDelete('cascade');
            $table->foreignId('menu_id')->after('transaksi_id')->constrained('menus')->onDelete('cascade');
            $table->integer('jumlah')->after('menu_id');
            $table->integer('subtotal')->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('detail_transaksis', function (Blueprint $table) {
            $table->dropForeign(['transaksi_id']);
            $table->dropForeign(['menu_id']);
            $table->dropColumn(['transaksi_id', 'menu_id', 'jumlah', 'subtotal']);
        });
    }
};
