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
        Schema::create('disciplinary_records', function (Blueprint $table) {
            $table->uuid('discipline_record_id')->primary();
            $table->uuid('member_id');

            $table->string('offense_type', 100);
            $table->text('offense_description');

            $table->string('discipline_type', 50);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('status', 20)->default('active'); // e.g., active, completed, appealed

            $table->uuid('recorded_by');
            $table->uuid('approved_by')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');
            $table->foreign('recorded_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinary_records');
    }
};
