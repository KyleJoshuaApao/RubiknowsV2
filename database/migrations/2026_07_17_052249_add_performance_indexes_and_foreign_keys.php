<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->index('category_id');
            $table->index('status');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('category');
            $table->index('is_featured');
        });

        Schema::table('career_jobs', function (Blueprint $table) {
            if (Schema::hasColumn('career_jobs', 'is_archived')) {
                $table->index('is_archived');
            }
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->index('job_id');
            $table->index('status');
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->index('status');
            $table->index('assigned_engineer_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['is_featured']);
        });

        Schema::table('career_jobs', function (Blueprint $table) {
            $table->dropIndex(['is_archived']);
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['job_id']);
            $table->dropIndex(['status']);
        });

        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['assigned_engineer_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });
    }
};
