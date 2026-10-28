<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Company news shown on the home page. Each post links to the full post on the
 * RubiKnows Facebook page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_posts', function (Blueprint $table): void {
            $table->id();
            $table->string('title')->nullable();
            $table->text('body');
            $table->text('image_path')->nullable();
            $table->dateTime('posted_at')->index();
            $table->string('facebook_url', 500);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_posts');
    }
};
