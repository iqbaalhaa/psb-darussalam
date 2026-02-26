<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->string('program_title')->nullable()->after('jadwal_note');
            $table->text('program_subtitle')->nullable()->after('program_title');
            $table->json('program_tabs')->nullable()->after('program_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['program_title', 'program_subtitle', 'program_tabs']);
        });
    }
};

