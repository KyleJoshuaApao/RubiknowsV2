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
        Schema::create('quotation_requests', function (Blueprint $table) {
                        $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('service_needed')->nullable();
            $table->string('project_location')->nullable();
            $table->string('budget')->nullable();
            $table->string('timeline')->nullable();
            $table->text('description')->nullable();
            $table->string('attachment_path')->nullable();
            $table->unsignedBigInteger('assigned_engineer_id')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_requests');
    }
};
