<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('hero_chip_location')->nullable()->after('brochure_url');
            $table->string('hero_chip_jenjang')->nullable()->after('hero_chip_location');
            $table->string('hero_chip_program')->nullable()->after('hero_chip_jenjang');
            $table->string('hero_image_path')->nullable()->after('hero_chip_program');
            $table->string('biaya_formal_total')->nullable()->after('hero_image_path');
            $table->string('biaya_nonformal_total')->nullable()->after('biaya_formal_total');
            $table->text('biaya_formal_items')->nullable()->after('biaya_nonformal_total');
            $table->text('biaya_nonformal_items')->nullable()->after('biaya_formal_items');
            $table->text('syarat_umum_items')->nullable()->after('biaya_nonformal_items');
            $table->text('berkas_items')->nullable()->after('syarat_umum_items');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};

