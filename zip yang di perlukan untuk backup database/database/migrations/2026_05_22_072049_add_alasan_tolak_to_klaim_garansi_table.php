<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // di file migration yang dibuat
    public function up()
    {
        Schema::table('klaim_garansi', function (Blueprint $table) {
            $table->text('alasan_tolak')->nullable()->after('status_klaim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klaim_garansi', function (Blueprint $table) {
            //
        });
    }
};
