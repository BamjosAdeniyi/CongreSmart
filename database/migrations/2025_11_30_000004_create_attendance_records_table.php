<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('member_id');
            $table->uuid('class_id')->nullable(); // FIXED nullable
            $table->date('date');
            $table->boolean('present')->default(false);
            $table->text('notes')->nullable();

            $table->uuid('marked_by')->nullable();
            $table->timestamps();

            // Proper business rule: one record per member per date
            $table->unique(['member_id', 'date']); // FIXED

            // Indexes
            $table->index(['class_id', 'date']);
            $table->index('member_id');
            $table->index('date');

            // FKs
            $table->foreign('member_id')
                  ->references('member_id')->on('members')
                  ->cascadeOnDelete(); // FIXED

            $table->foreign('class_id')
                  ->references('id')->on('sabbath_school_classes')
                  ->nullOnDelete();

            $table->foreign('marked_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};
