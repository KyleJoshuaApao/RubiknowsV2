<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table): void {
            $table->text('image_url')->nullable()->after('icon');
        });

        Schema::table('testimonials', function (Blueprint $table): void {
            $table->text('avatar_url')->nullable()->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table): void {
            $table->dropColumn('avatar_url');
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->dropColumn('image_url');
        });
    }
};
