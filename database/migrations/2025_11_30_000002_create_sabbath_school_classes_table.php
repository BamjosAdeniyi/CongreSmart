<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sabbath_school_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->unique();
            $table->text('description')->nullable();

            $table->uuid('coordinator_id')->nullable(); // FIXED nullable
            $table->string('age_range', 50)->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('coordinator_id')
                  ->references('id')->on('users')
                  ->nullOnDelete(); // FIXED
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sabbath_school_classes');
    }
};
