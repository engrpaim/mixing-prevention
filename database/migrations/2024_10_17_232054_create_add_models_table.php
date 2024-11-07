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
            $table->string('model_name')->unique('model_name');
            $table->decimal('width')->default(0.00);
            $table->decimal('max_tolerance_width')->default(0.00);
            $table->decimal('min_tolerance_width')->default(0.00);
            $table->decimal('length')->default(0.00);
            $table->decimal('max_tolerance_length')->default(0.00);
            $table->decimal('min_tolerance_length')->default(0.00);
            $table->decimal('thickness')->default(0.00);
            $table->decimal('max_tolerance_thickness')->default(0.00);
            $table->decimal('min_tolerance_thickness')->default(0.00);
            $table->string('ip_address')->default('UNKNOWN');
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
