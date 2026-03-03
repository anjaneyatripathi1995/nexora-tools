<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saved_items', function (Blueprint $table) {
            if (!Schema::hasColumn('saved_items', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('saved_items', 'item_type')) {
                $table->string('item_type', 32)->after('user_id'); // tool, project, app, template
            }
            if (!Schema::hasColumn('saved_items', 'item_slug')) {
                $table->string('item_slug', 128)->after('item_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('saved_items', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['item_type', 'item_slug']);
        });
    }
};
