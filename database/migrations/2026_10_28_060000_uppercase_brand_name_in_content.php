<?php

use App\Support\PublicContentCache;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The company name is written RUBIKNOWS everywhere, including content stored in the database.
 */
return new class extends Migration
{
    private const COLUMNS = [
        'settings' => ['value'],
        'services' => ['title', 'description'],
        'jobs' => ['title', 'description'],
        'projects' => ['title', 'description'],
        'news_posts' => ['title', 'body'],
        'testimonials' => ['quote'],
    ];

    public function up(): void
    {
        foreach (self::COLUMNS as $table => $columns) {
            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    continue;
                }

                DB::table($table)
                    ->where($column, 'like', '%ubi%nows%')
                    ->update([$column => DB::raw("replace(replace({$column}, 'RubiKnows', 'RUBIKNOWS'), 'Rubiknows', 'RUBIKNOWS')")]);
            }
        }

        PublicContentCache::forgetPublicContent();
        PublicContentCache::forgetSettings();
    }

    public function down(): void
    {
        // The original capitalisation is not recoverable and is not needed.
    }
};
