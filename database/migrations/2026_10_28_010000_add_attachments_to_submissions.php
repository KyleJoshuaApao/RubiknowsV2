<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Messages and quotation requests can carry several optional files.
 * Each entry is {path, name, size}; files live on the private documents disk.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['contact_messages', 'quotation_requests'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->json('attachments')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['contact_messages', 'quotation_requests'] as $table) {
            Schema::table($table, function (Blueprint $table): void {
                $table->dropColumn('attachments');
            });
        }
    }
};
