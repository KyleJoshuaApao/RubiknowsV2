<?php

use App\Support\PublicContentCache;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The owner chose to show the map, projects, gallery photos and news to every
 * visitor, so rows previously limited to signed-in admins become public.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['projects', 'gallery_media', 'news_posts'] as $table) {
            DB::table($table)->where('is_preview', true)->update(['is_preview' => false]);
        }

        PublicContentCache::forgetPublicContent();
    }

    public function down(): void
    {
        // Rows cannot be told apart from real ones afterwards; nothing to restore.
    }
};
