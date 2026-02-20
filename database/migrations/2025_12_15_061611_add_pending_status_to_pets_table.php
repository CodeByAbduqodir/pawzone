<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pets_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'pending', 'sold'])->default('available');
            $table->timestamps();
        });

        DB::statement('INSERT INTO pets_temp SELECT * FROM pets');

        Schema::dropIfExists('pets');

        Schema::rename('pets_temp', 'pets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pets_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->timestamps();
        });

        DB::statement('INSERT INTO pets_temp SELECT * FROM pets WHERE status IN ("available", "sold")');
        Schema::dropIfExists('pets');
        Schema::rename('pets_temp', 'pets');
    }
};
