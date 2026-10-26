<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * New accounts used to default to "Administrator". Admin access is now
     * granted by explicit role only, so new rows default to a role with none.
     * Existing "Administrator" rows are left untouched for manual review.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('User')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('Administrator')->change();
        });
    }
};
