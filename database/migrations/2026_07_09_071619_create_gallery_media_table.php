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
        Schema::create('gallery_media', function (Blueprint $table) {
                        $table->id();
            $table->string('type');
            $table->string('title')->nullable();
            $table->string('url');
            $table->string('thumbnail_url')->nullable();
            $table->string('album_name')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('before_after_pair_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_media');
    }
};
