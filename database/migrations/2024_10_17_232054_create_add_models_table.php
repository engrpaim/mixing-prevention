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
        Schema::create('add_models', function (Blueprint $table) {
            $table->id()->autoIncrement()->primary();
            $table->string('model')->unique('model_name');
            $table->string('before');
            $table->string('after');
            $table->string('finish');
            $table->string('process_flow');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_models');
    }
};
