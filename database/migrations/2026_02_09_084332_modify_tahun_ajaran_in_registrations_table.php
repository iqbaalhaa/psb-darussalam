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
        // We cannot convert back to YEAR because the data might be in "YYYY/YYYY" format (e.g. 2025/2026)
        // which causes data truncation errors. 
        // We leave it as VARCHAR or just let the previous migration drop the column if it's being rolled back further.
        // DB::statement("ALTER TABLE registrations MODIFY COLUMN tahun_ajaran YEAR NULL DEFAULT NULL");
        
        // Use VARCHAR to be safe during rollback
        DB::statement("ALTER TABLE registrations MODIFY COLUMN tahun_ajaran VARCHAR(20) NULL DEFAULT NULL");
    }
};
