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
        Schema::table('pets', function (Blueprint $table) {
            // Тип объявления: lost = пропал, found = нашли
            $table->enum('type', ['lost', 'found'])->default('lost')->after('user_id');
            // Контактный телефон
            $table->string('phone')->nullable()->after('description');
            // Регион/место
            $table->string('location')->nullable()->after('phone');
            // Дата пропажи/обнаружения
            $table->date('incident_date')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn(['type', 'phone', 'location', 'incident_date']);
        });
    }
};
