<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE registrations MODIFY COLUMN tahun_ajaran VARCHAR(20) NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Convert back to YEAR, but be aware that data might be lost/truncated if it's not a valid year
        DB::statement("ALTER TABLE registrations MODIFY COLUMN tahun_ajaran YEAR NULL DEFAULT NULL");
    }
};
