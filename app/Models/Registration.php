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
        'email',
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
        'nama_ayah',
        'nama_ibu',
        'no_hp_wali',
        'foto',
        'kk_file',
        'akte_file',
        'ijazah_file',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
