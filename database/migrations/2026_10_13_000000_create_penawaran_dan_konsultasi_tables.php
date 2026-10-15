<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| FITUR BARU: Minta Penawaran Resmi & Konsultasi Teknis
|--------------------------------------------------------------------------
| Hanya MENAMBAH dua tabel baru. Tabel lama (pesanan, tracking_pesanan,
| klaim_garansi, serial_produk, tiket_teknisi, verifikasi_garansi, dst.)
| tidak diubah dan tidak dihapus, hanya tidak dipakai lagi oleh website.
|
| Kolom id_produk / id_user_* sengaja TANPA foreign key constraint, supaya
| cocok dengan tipe kolom di database lama (bisa INT atau BIGINT).
| down() hanya menghapus dua tabel baru ini.
*/

return new class extends Migration
{
    public function up(): void
    {
        // ================= PERMINTAAN PENAWARAN =================

        Schema::create('permintaan_penawaran', function (Blueprint $table) {
            $table->id('id_penawaran');
            $table->string('nomor_permintaan')->unique();

            // data pemohon
            $table->string('nama_pemohon');
            $table->string('nama_perusahaan')->nullable();
            $table->string('email');
            $table->string('nomor_telepon', 30);

            // kebutuhan
            $table->unsignedBigInteger('id_produk')->nullable()->index();
            $table->string('jenis_produk', 50);               // zinc / aluminium / belum_tahu
            $table->string('tipe_ukuran')->nullable();
            $table->unsignedInteger('jumlah');
            $table->string('satuan', 30)->default('pcs');

            // tujuan
            $table->string('jenis_kapal')->nullable();
            $table->string('lokasi_pengiriman');
            $table->date('tanggal_dibutuhkan')->nullable();

            $table->string('file_lampiran')->nullable();
            $table->text('catatan')->nullable();

            // penanganan oleh admin
            $table->string('status', 30)->default('baru');    // baru / diproses / penawaran_terkirim / selesai / dibatalkan
            $table->text('catatan_admin')->nullable();
            $table->unsignedBigInteger('id_user_proses')->nullable()->index();

            $table->timestamps();
        });

        // ================= KONSULTASI TEKNIS =================

        Schema::create('konsultasi_teknis', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->string('nomor_konsultasi')->unique();

            // data pengirim
            $table->string('nama_pengirim');
            $table->string('nama_perusahaan')->nullable();
            $table->string('email');
            $table->string('nomor_telepon', 30);

            // kondisi kapal
            $table->unsignedBigInteger('id_produk')->nullable()->index();   // produk yang diminati (opsional)
            $table->string('jenis_kapal');
            $table->string('ukuran_kapal')->nullable();
            $table->string('bagian_dilindungi')->nullable();
            $table->string('kondisi_air', 30);                     // laut / payau / tawar / belum_tahu
            $table->text('pertanyaan');

            // penanganan oleh admin
            $table->string('status', 30)->default('baru');         // baru / dibalas / selesai
            $table->text('balasan_admin')->nullable();
            $table->unsignedBigInteger('id_user_balas')->nullable()->index();
            $table->dateTime('dibalas_pada')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasi_teknis');
        Schema::dropIfExists('permintaan_penawaran');
    }
};
