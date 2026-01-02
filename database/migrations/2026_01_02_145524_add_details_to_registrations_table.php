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
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nisn')->nullable();
            $table->string('nik')->nullable();
            $table->text('alamat')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('no_hp_wali')->nullable();
            $table->string('foto')->nullable();
            $table->string('kk_file')->nullable();
            $table->string('akte_file')->nullable();
            $table->string('ijazah_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'nisn',
                'nik',
                'alamat',
                'asal_sekolah',
                'nama_ayah',
                'nama_ibu',
                'no_hp_wali',
                'foto',
                'kk_file',
                'akte_file',
                'ijazah_file',
            ]);
        });
    }
};
