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
            $columns = [
                'tempat_lahir' => 'string',
                'tanggal_lahir' => 'date',
                'jenis_kelamin' => 'enum:L,P',
                'nisn' => 'string',
                'nik' => 'string',
                'alamat' => 'text',
                'asal_sekolah' => 'string',
                // anak_ke and jumlah_saudara handled in previous migration
                
                // Data Orang Tua
                'no_kk' => 'string',
                'nama_ayah' => 'string',
                'nik_ayah' => 'string',
                'umur_ayah' => 'integer',
                'tempat_lahir_ayah' => 'string',
                'tanggal_lahir_ayah' => 'date',
                'pendidikan_terakhir_ayah' => 'string',
                'alamat_lengkap_ayah' => 'string',
                'pekerjaan_ayah' => 'string',
                'no_hp_ayah' => 'string',
                'kode_pos' => 'string',

                'nama_ibu' => 'string',
                'nik_ibu' => 'string',
                'umur_ibu' => 'integer',
                'tempat_lahir_ibu' => 'string',
                'tanggal_lahir_ibu' => 'date',
                'pendidikan_terakhir_ibu' => 'string',
                'alamat_lengkap_ibu' => 'string',
                'pekerjaan_ibu' => 'string',
                'no_hp_ibu' => 'string',

                // Files
                'file_biodata' => 'string',
                'file_rapor' => 'string',
                'file_ijazah' => 'string',
                'file_skl' => 'string',
                'file_akta_kelahiran' => 'string',
                'file_kk' => 'string',
                'file_pas_foto' => 'string',
                'file_ktp_ayah' => 'string',
                'file_ktp_ibu' => 'string',
                'file_kip' => 'string',
                'file_bpjs' => 'string',
            ];

            foreach ($columns as $column => $type) {
                if (!Schema::hasColumn('registrations', $column)) {
                    if ($type === 'string') {
                        $table->string($column)->nullable();
                    } elseif ($type === 'text') {
                        $table->text($column)->nullable();
                    } elseif ($type === 'date') {
                        $table->date($column)->nullable();
                    } elseif ($type === 'integer') {
                        $table->integer($column)->nullable();
                    } elseif ($type === 'enum:L,P') {
                        $table->enum($column, ['L', 'P'])->nullable();
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // No drop needed as we are fixing missing columns
        });
    }
};
