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
        Schema::create('member_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('member_id');
            $table->enum('transfer_type', ['class', 'church']);
            $table->enum('status', ['pending', 'completed', 'rejected']);
            $table->enum('direction', ['from', 'to'])->default('to');
            $table->string('church_name')->nullable();
            $table->uuid('from_class_id')->nullable();
            $table->uuid('to_class_id')->nullable();
            $table->date('transfer_date');
            $table->text('reason')->nullable();
            $table->text('notes')->nullable();
            $table->uuid('processed_by')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            $table->foreign('from_class_id')->references('id')->on('sabbath_school_classes')->onDelete('set null');
            $table->foreign('to_class_id')->references('id')->on('sabbath_school_classes')->onDelete('set null');
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_transfers');
    }
};
