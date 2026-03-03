<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tool_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('status')->default('pending'); // pending,running,done,failed
            $table->unsignedInteger('progress')->default(0);
            $table->json('input_paths')->nullable();
            $table->string('result_path')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tool_jobs');
    }
};
