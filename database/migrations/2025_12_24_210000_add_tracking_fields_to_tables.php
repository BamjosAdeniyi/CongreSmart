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
        Schema::table('sabbath_school_classes', function (Blueprint $table) {
            $table->uuid('created_by')->nullable()->after('active');
            $table->uuid('updated_by')->nullable()->after('created_by');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('attendance_records', function (Blueprint $table) {
            $table->uuid('updated_by')->nullable()->after('marked_by');
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::table('contributions', function (Blueprint $table) {
            $table->uuid('updated_by')->nullable()->after('recorded_by');
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sabbath_school_classes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });

        Schema::table('attendance_records', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['updated_by']);
        });

        Schema::table('contributions', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['updated_by']);
        });
    }
};
