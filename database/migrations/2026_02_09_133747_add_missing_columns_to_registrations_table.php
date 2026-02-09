<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('registrations', 'anak_ke')) {
                $table->integer('anak_ke')->nullable()->after('asal_sekolah');
            }
            if (!Schema::hasColumn('registrations', 'jumlah_saudara')) {
                $table->integer('jumlah_saudara')->nullable()->after('anak_ke');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            if (Schema::hasColumn('registrations', 'anak_ke')) {
                $table->dropColumn('anak_ke');
            }
            if (Schema::hasColumn('registrations', 'jumlah_saudara')) {
                $table->dropColumn('jumlah_saudara');
            }
        });
    }
};
