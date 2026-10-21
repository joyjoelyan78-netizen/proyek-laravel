
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('konsultasi_teknis', 'produk_diminati')) {
            Schema::table('konsultasi_teknis', function (Blueprint $table) {
                $table->string('produk_diminati')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('konsultasi_teknis', function (Blueprint $table) {
            $table->dropColumn('produk_diminati');
        });
    }
};
