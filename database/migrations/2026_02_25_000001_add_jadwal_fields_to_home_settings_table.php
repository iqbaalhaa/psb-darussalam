<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('jadwal_title')->nullable()->after('berkas_items');
            $table->text('jadwal_subtitle')->nullable()->after('jadwal_title');
            $table->json('jadwal_rows')->nullable()->after('jadwal_subtitle');
            $table->text('jadwal_note')->nullable()->after('jadwal_rows');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['jadwal_title', 'jadwal_subtitle', 'jadwal_rows', 'jadwal_note']);
        });
    }
};

