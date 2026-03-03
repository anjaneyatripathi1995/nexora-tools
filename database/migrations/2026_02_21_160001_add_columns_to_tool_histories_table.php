<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tool_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('tool_histories', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('tool_histories', 'tool_slug')) {
                $table->string('tool_slug', 128)->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('tool_histories', 'tool_id')) {
                $table->foreignId('tool_id')->nullable()->after('tool_slug')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('tool_histories', 'metadata')) {
                $table->json('metadata')->nullable()->after('tool_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tool_histories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['tool_id']);
            $table->dropColumn(['user_id', 'tool_slug', 'tool_id', 'metadata']);
        });
    }
};
