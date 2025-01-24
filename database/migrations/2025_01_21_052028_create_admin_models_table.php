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
        Schema::create('admin_models', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->unique('ip');
            $table->string('name')->unique('name');
            $table->string('area');
            $table->string('model')->default('off');
            $table->string('view')->default('off');
            $table->string('manage')->default('off');
            $table->string('addedBy');
            $table->timestamp('created_At')->useCurrent();
            $table->timestamp('update_At')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_models');
    }
};
