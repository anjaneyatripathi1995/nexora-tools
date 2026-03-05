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
        // This check prevents the "table already exists" error
        if (!Schema::hasTable('tool_histories')) {
            Schema::create('tool_histories', function (Blueprint $table) {
                $table->id();
                // Add your columns here if they aren't already in the DB
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_histories');
    }
};
