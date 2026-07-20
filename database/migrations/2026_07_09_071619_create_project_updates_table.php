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
        Schema::create('project_updates', function (Blueprint $table) {
                        $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('update_title');
            $table->text('description')->nullable();
            $table->integer('progress_percentage')->default(0);
            $table->date('update_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_updates');
    }
};
