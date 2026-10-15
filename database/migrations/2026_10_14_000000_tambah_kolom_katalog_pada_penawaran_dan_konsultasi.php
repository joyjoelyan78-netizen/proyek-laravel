<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Penyesuaian dengan katalog VESCA
|--------------------------------------------------------------------------
| - permintaan_penawaran.rincian_item : daftar item (seri, tipe, jumlah)
|   dalam bentuk teks JSON, supaya satu permintaan bisa berisi banyak tipe.
| - konsultasi_teknis.produk_diminati : seri produk yang diminati
|   (kode seri dari config/katalog_vesca.php).
|
| Hanya MENAMBAH kolom. Data yang sudah ada tidak berubah.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_penawaran', function (Blueprint $table) {
            $table->text('rincian_item')->nullable()->after('id_produk');
        });

        Schema::table('konsultasi_teknis', function (Blueprint $table) {
            $table->string('produk_diminati', 150)->nullable()->after('id_produk');
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_penawaran', function (Blueprint $table) {
            $table->dropColumn('rincian_item');
        });

        Schema::table('konsultasi_teknis', function (Blueprint $table) {
            $table->dropColumn('produk_diminati');
        });
    }
};
