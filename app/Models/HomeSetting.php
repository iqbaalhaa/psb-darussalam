<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_lead',
        'hero_muted',
        'wa_number_display',
        'wa_number_e164',
        'wa_default_text',
        'brochure_url',
        'hero_chip_location',
        'hero_chip_jenjang',
        'hero_chip_program',
        'hero_image_path',
        'biaya_formal_total',
        'biaya_nonformal_total',
        'biaya_formal_items',
        'biaya_nonformal_items',
        'syarat_umum_items',
        'berkas_items',
        'jadwal_title',
        'jadwal_subtitle',
        'jadwal_rows',
        'jadwal_note',
        'program_title',
        'program_subtitle',
        'program_tabs',
    ];

    protected $casts = [
        'jadwal_rows' => 'array',
        'program_tabs' => 'array',
    ];
}
