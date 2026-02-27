<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pets')->where('status', 'sold')->update(['status' => 'resolved']);
    }

    public function down(): void
    {
        DB::table('pets')->where('status', 'resolved')->update(['status' => 'sold']);
    }
};
