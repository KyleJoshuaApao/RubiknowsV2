<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Older rows mixed "client"/"Client" and left the type empty. Store one
     * canonical value per type so queries can match exactly.
     */
    public function up(): void
    {
        foreach (['Client', 'Partner', 'Sponsor'] as $type) {
            DB::table('clients')
                ->whereRaw('LOWER(TRIM(type)) = ?', [strtolower($type)])
                ->update(['type' => $type]);
        }

        DB::table('clients')
            ->where(fn ($query) => $query->whereNull('type')->orWhere('type', ''))
            ->update(['type' => 'Client']);
    }

    public function down(): void
    {
        // Normalised values are valid in the old schema; nothing to undo.
    }
};
