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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('pet_id')->nullable()->constrained('pets')->onDelete('cascade');
            $table->enum('action', ['created', 'updated', 'deleted', 'moderated']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->enum('status', ['approved', 'rejected', 'pending'])->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();

            // indexes для быстрого поиска
            $table->index('user_id');
            $table->index('pet_id');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
