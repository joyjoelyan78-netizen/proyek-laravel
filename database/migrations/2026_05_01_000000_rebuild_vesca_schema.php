<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| REBUILD SKEMA DATABASE (db_vesca_rindo)
|--------------------------------------------------------------------------
| Dibangun ulang dari Models + Controllers karena database aslinya hilang.
| Ini adalah kondisi AKHIR skema (sudah termasuk efek 6 migration "alter"
| lama), jadi migration alter lama itu harus dipindah keluar dari
| database/migrations (lihat panduan).
|
| TIDAK dibuat di sini (sudah ada migration bawaan project):
|   permissions, role_permissions, password_reset_tokens,
|   failed_jobs, personal_access_tokens
|
| Kolom yang bertanda "TEBAKAN" tipenya disimpulkan dari kode, bukan dari
| database aslinya. Kalau form di views memakai tipe lain, sesuaikan.
*/

return new class extends Migration
{
    public function up(): void
    {
        // ================= USERS & ROLE =================

        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role');
            $table->text('deskripsi')->nullable();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_role');

            $table->primary(['id_user', 'id_role']);

            $table->foreign('id_user')->references('id_user')->on('users')->cascadeOnDelete();
            $table->foreign('id_role')->references('id_role')->on('roles')->cascadeOnDelete();
        });

        // ================= PRODUK =================

        Schema::create('kategori_produk', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100);
            $table->string('slug')->nullable()->unique();
            $table->text('deskripsi')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->unsignedBigInteger('id_kategori');
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->string('seri_produk')->nullable();
            $table->string('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('catatan_ppn')->nullable();
            $table->string('berat', 100)->nullable();              // TEBAKAN: string
            $table->string('dimensi')->nullable();                 // TEBAKAN: string
            $table->text('standar_kualitas')->nullable();
            $table->text('lingkungan_operasi')->nullable();
            $table->date('tanggal_produksi')->nullable();
            $table->unsignedInteger('masa_garansi_bulan')->nullable();
            $table->text('komposisi_material')->nullable();
            $table->string('gambar_produk')->nullable();
            $table->string('link_whatsapp', 500)->nullable();
            $table->string('status_produk', 50)->default('aktif'); // TEBAKAN: nilai
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();                                 // Produk memakai SoftDeletes

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_produk');
        });

        // ================= MASTER DATA =================

        Schema::create('customer', function (Blueprint $table) {
            $table->id('id_customer');
            $table->string('nama_customer');
            $table->string('email')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('kapal', function (Blueprint $table) {
            $table->id('id_kapal');
            $table->string('jenis_kapal');
            $table->string('nama_kapal');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('teknisi', function (Blueprint $table) {
            $table->id('id_teknisi');
            $table->string('nama_teknisi');
            $table->string('email')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('status_teknisi', 50)->default('aktif'); // TEBAKAN: nilai
        });

        // ================= PESANAN =================

        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_customer');
            $table->string('nomor_invoice')->unique();
            $table->date('tanggal_order')->nullable();
            $table->date('estimasi_selesai')->nullable();
            $table->unsignedTinyInteger('progres_persen')->default(0);
            $table->string('status_pesanan', 50)->default('pending'); // TEBAKAN: nilai
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_customer')->references('id_customer')->on('customer');
        });

        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedInteger('qty');
            $table->decimal('berat_per_unit', 10, 2)->default(0);
            $table->decimal('total_berat', 12, 2)->default(0);
            $table->decimal('harga', 15, 2);
            $table->decimal('subtotal', 15, 2);

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk');
        });

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_user_input')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->string('metode_pembayaran', 100)->nullable();
            $table->string('status_pembayaran', 50);                // TEBAKAN: nilai
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_user_input')->references('id_user')->on('users')->nullOnDelete();
        });

        Schema::create('status_tracking', function (Blueprint $table) {
            $table->id('id_status_tracking');
            $table->string('nama_status');
            $table->unsignedInteger('urutan')->default(0);
        });

        Schema::create('tracking_pesanan', function (Blueprint $table) {
            $table->id('id_tracking');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_status_tracking');
            $table->unsignedBigInteger('id_user_update')->nullable();
            $table->string('status', 50);                           // salah satunya: 'selesai'
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('estimasi_selesai')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('pic', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->cascadeOnDelete();
            $table->foreign('id_status_tracking')->references('id_status_tracking')->on('status_tracking');
            $table->foreign('id_user_update')->references('id_user')->on('users')->nullOnDelete();
        });

        // ================= SERIAL & GARANSI =================

        Schema::create('serial_produk', function (Blueprint $table) {
            $table->id('id_serial');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_pesanan')->nullable();
            $table->unsignedBigInteger('id_detail_pesanan')->nullable();
            $table->string('kode_unik')->unique();
            $table->string('status_aktivasi', 50)->default('belum');
            $table->string('status_klaim', 50)->default('belum');
            $table->string('status_garansi', 50)->default('belum');
            $table->date('tanggal_aktivasi')->nullable();
            $table->date('tanggal_klaim')->nullable();
            $table->date('masa_berlaku_sampai')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->nullOnDelete();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->nullOnDelete();
            $table->foreign('id_detail_pesanan')->references('id_detail')->on('detail_pesanan')->nullOnDelete();
        });

        Schema::create('klaim_garansi', function (Blueprint $table) {
            $table->id('id_klaim');
            $table->unsignedBigInteger('id_serial')->nullable();
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_produk')->nullable();
            $table->unsignedBigInteger('id_kapal')->nullable();     // sisa lama, sudah tidak dipakai Model
            $table->string('nama_pembeli')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_telepon', 30)->nullable();
            $table->string('judul_keluhan')->nullable();
            $table->text('deskripsi_keluhan')->nullable();
            $table->string('status_klaim', 50)->default('pending');
            $table->text('alasan_tolak')->nullable();
            $table->dateTime('tanggal_klaim')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_serial')->references('id_serial')->on('serial_produk')->nullOnDelete();
            $table->foreign('id_customer')->references('id_customer')->on('customer')->nullOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk')->nullOnDelete();
            $table->foreign('id_kapal', 'fk_klaim_kapal')->references('id_kapal')->on('kapal')->nullOnDelete();
        });

        Schema::create('upload_foto', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('id_klaim');
            $table->string('file_foto');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_klaim')->references('id_klaim')->on('klaim_garansi')->cascadeOnDelete();
        });

        Schema::create('tiket_teknisi', function (Blueprint $table) {
            $table->id('id_tiket');
            $table->unsignedBigInteger('id_klaim')->unique();       // validasi unique:tiket_teknisi,id_klaim
            $table->string('nomor_tiket')->unique();
            $table->unsignedBigInteger('id_teknisi')->nullable();
            $table->date('estimasi_kunjungan')->nullable();         // TEBAKAN: date
            $table->string('status_tiket', 50)->default('diterima');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_klaim')->references('id_klaim')->on('klaim_garansi')->cascadeOnDelete();
            $table->foreign('id_teknisi')->references('id_teknisi')->on('teknisi')->nullOnDelete();
        });

        Schema::create('verifikasi_garansi', function (Blueprint $table) {
            $table->id('id_verifikasi');
            $table->unsignedBigInteger('id_klaim')->unique();
            $table->unsignedBigInteger('id_teknisi')->nullable();
            $table->unsignedBigInteger('id_user_verifikasi')->nullable();
            $table->dateTime('tanggal_verifikasi')->nullable();
            $table->date('garansi_mulai')->nullable();
            $table->string('status_verifikasi', 50)->default('pending'); // 'valid' / 'tidak_valid' / 'pending'
            $table->text('catatan_verifikasi')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();
            $table->date('tanggal_kunjungan')->nullable();
            $table->time('jam_kunjungan')->nullable();
            $table->enum('status_kunjungan', ['menunggu', 'dijadwalkan', 'proses', 'selesai'])
                  ->default('menunggu');

            $table->foreign('id_klaim')->references('id_klaim')->on('klaim_garansi')->cascadeOnDelete();
            $table->foreign('id_teknisi')->references('id_teknisi')->on('teknisi')->nullOnDelete();
            $table->foreign('id_user_verifikasi')->references('id_user')->on('users')->nullOnDelete();
        });

        // ================= LOG =================

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_user')->nullable();
            $table->text('aktivitas');
            $table->string('tabel_terkait', 100)->nullable();
            $table->unsignedBigInteger('id_data')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_user')->references('id_user')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach ([
            'activity_logs', 'verifikasi_garansi', 'tiket_teknisi', 'upload_foto',
            'klaim_garansi', 'serial_produk', 'tracking_pesanan', 'status_tracking',
            'pembayaran', 'detail_pesanan', 'pesanan', 'teknisi', 'kapal', 'customer',
            'produk', 'kategori_produk', 'role_user', 'roles', 'users',
        ] as $tabel) {
            Schema::dropIfExists($tabel);
        }

        Schema::enableForeignKeyConstraints();
    }
};
