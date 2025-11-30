<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('member_id');
            $table->uuid('category_id');
            $table->decimal('amount', 12, 2);
            $table->date('date');

            $table->string('payment_method', 50)->nullable();
            $table->string('reference_number')->nullable();
            $table->text('notes')->nullable();
            $table->uuid('recorded_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['date', 'category_id']);
            $table->index('member_id');

            // FKs (corrected PK name)
            $table->foreign('member_id')
                  ->references('member_id')->on('members')
                  ->cascadeOnDelete();

            $table->foreign('category_id')
                  ->references('id')->on('financial_categories')
                  ->restrictOnDelete();

            $table->foreign('recorded_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
