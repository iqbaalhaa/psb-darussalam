<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->text('hero_lead')->nullable();
            $table->text('hero_muted')->nullable();
            $table->string('wa_number_display')->nullable();
            $table->string('wa_number_e164')->nullable();
            $table->text('wa_default_text')->nullable();
            $table->string('brochure_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};

