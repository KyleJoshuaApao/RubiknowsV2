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
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->timestamp('replied_at')->nullable();
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->timestamp('replied_at')->nullable();
        });

        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->text('reply_message')->nullable();
            $table->timestamp('replied_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'replied_at']);
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'replied_at']);
        });

        Schema::table('quotation_requests', function (Blueprint $table) {
            $table->dropColumn(['reply_message', 'replied_at']);
        });
    }
};
