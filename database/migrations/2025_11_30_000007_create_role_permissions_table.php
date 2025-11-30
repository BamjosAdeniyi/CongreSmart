<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->enum('role', [
                'pastor', 'clerk', 'welfare',
                'superintendent', 'coordinator',
                'financial', 'ict'
            ])->unique();

            // Members
            $table->boolean('members_view')->default(false);
            $table->boolean('members_add')->default(false);
            $table->boolean('members_edit')->default(false);
            $table->boolean('members_delete')->default(false);

            // Sabbath School
            $table->boolean('sabbath_school_view')->default(false);
            $table->boolean('sabbath_school_manage')->default(false);
            $table->boolean('sabbath_school_mark_attendance')->default(false);

            // Finance
            $table->boolean('finance_view')->default(false);
            $table->boolean('finance_record')->default(false);
            $table->boolean('finance_reports')->default(false);

            // Reports
            $table->boolean('reports_view')->default(false);
            $table->boolean('reports_export')->default(false);

            // Settings & Users
            $table->boolean('settings_view')->default(false);
            $table->boolean('settings_edit')->default(false);
            $table->boolean('users_view')->default(false);
            $table->boolean('users_manage')->default(false);

            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('updated_by')
                  ->references('id')->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
