<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'jenjang',
        // 'email',
        'wa',
        'status',
        'is_locked',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nisn',
        'nik',
        'alamat',
        'asal_sekolah',
        'anak_ke',
        'jumlah_saudara',

        // Data Orang Tua/Wali
        // Data Ayah
        'nama_ayah',
        'no_kk',
        'nik_ayah',
        'umur_ayah',
        'tempat_lahir_ayah',
        'tanggal_lahir_ayah',
        'pendidikan_terakhir_ayah',
        'alamat_lengkap_ayah',
        'pekerjaan_ayah',
        'no_hp_ayah',
        'kode_pos',

        // Data Ibu
        'nik_ibu',
        'nama_ibu',
        'umur_ibu',
        'tempat_lahir_ibu',
        'tanggal_lahir_ibu',
        'pendidikan_terakhir_ibu',
        'alamat_lengkap_ibu',
        'pekerjaan_ibu',
        'no_hp_ibu',

        'keterangan',
        'status_pembayaran',

        // Berkas
        'file_biodata',
        'file_rapor',
        'file_ijazah',
        'file_skl',
        'file_akta_kelahiran',
        'file_kk',
        'file_pas_foto',
        'file_ktp_ayah',
        'file_ktp_ibu',
        'file_kip',
        'file_bpjs',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
