<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Job requirements were a 255-character column, so longer qualification lists
 * failed to save on Postgres. Store them as text like the job description.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('career_jobs', function (Blueprint $table): void {
            $table->text('requirements')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('career_jobs', function (Blueprint $table): void {
            $table->string('requirements')->nullable()->change();
        });
    }
};
