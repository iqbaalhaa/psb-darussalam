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

            $table->year('tahun_ajaran')->default(date('Y'));
            // Data Pertama

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('nisn')->nullable();
            $table->string('nik')->nullable();
            $table->text('alamat')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara')->nullable();

            // Data Kedua (Data Orang Tua/Wali)
            $table->string('no_kk')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah')->nullable();
            $table->integer('umur_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->string('pendidikan_terakhir_ayah')->nullable();
            $table->string('alamat_lengkap_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('no_hp_ayah')->nullable();
            $table->string('kode_pos')->nullable();

            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu')->nullable();
            $table->integer('umur_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->string('pendidikan_terakhir_ibu')->nullable();
            $table->string('alamat_lengkap_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('no_hp_ibu')->nullable();

            // Data Ketiga
            $table->string('file_biodata')->nullable();
            $table->string('file_rapor')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_skl')->nullable();
            $table->string('file_akta_kelahiran')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_pas_foto')->nullable();
            $table->string('file_ktp_ayah')->nullable();
            $table->string('file_ktp_ibu')->nullable();
            $table->string('file_kip')->nullable();
            $table->string('file_bpjs')->nullable();

            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->string('status_pembayaran')->default('belum_lunas');
            $table->string('keterangan')->nullable();
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
