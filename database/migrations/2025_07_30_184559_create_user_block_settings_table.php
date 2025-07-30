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
        Schema::create('user_block_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('project_name')->nullable(); // For different projects/templates
            $table->json('settings_data'); // Store all block settings as JSON
            $table->timestamp('last_modified')->useCurrent();
            $table->timestamps();
            
            // Ensure each user can have only one settings record per project
            $table->unique(['user_id', 'project_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_block_settings');
    }
};
