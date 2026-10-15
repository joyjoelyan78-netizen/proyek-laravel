<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('verifikasi_garansi', function (Blueprint $table) {

            $table->date('tanggal_kunjungan')->nullable();

            $table->time('jam_kunjungan')->nullable();

            $table->enum('status_kunjungan', [
                'menunggu',
                'dijadwalkan',
                'proses',
                'selesai'
            ])->default('menunggu');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifikasi_garansi', function (Blueprint $table) {
            //
        });
    }
};
