<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tool_usage_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained('tools')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedBigInteger('count')->default(0);
            $table->timestamps();
            $table->unique(['tool_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tool_usage_stats');
    }
};
