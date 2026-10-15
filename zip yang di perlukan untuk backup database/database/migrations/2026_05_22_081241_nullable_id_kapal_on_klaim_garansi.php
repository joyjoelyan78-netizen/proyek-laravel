<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('klaim_garansi', function (Blueprint $table) {

            // 1. Drop foreign key dulu
            $table->dropForeign('fk_klaim_kapal');

            // 2. Baru ubah kolom jadi nullable
            $table->unsignedBigInteger('id_kapal')->nullable()->default(null)->change();

            // 3. Pasang lagi foreign key tapi sekarang nullable
            $table->foreign('id_kapal', 'fk_klaim_kapal')
                  ->references('id_kapal')
                  ->on('kapal')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('klaim_garansi', function (Blueprint $table) {

            $table->dropForeign('fk_klaim_kapal');

            $table->unsignedBigInteger('id_kapal')->nullable(false)->change();

            $table->foreign('id_kapal', 'fk_klaim_kapal')
                  ->references('id_kapal')
                  ->on('kapal');
        });
    }
};