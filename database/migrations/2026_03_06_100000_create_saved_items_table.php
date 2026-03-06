<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('item_type', 50);
            $table->string('item_slug', 255);
            $table->timestamps();
            $table->unique(['user_id', 'item_type', 'item_slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_items');
    }
};
