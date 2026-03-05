<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            if (!Schema::hasColumn('tools', 'status')) {
                $table->string('status', 20)->default('active')->after('is_active');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('tools', 'status')) {
            Schema::table('tools', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
