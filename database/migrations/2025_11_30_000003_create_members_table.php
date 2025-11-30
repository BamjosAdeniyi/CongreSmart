<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('member_id')->primary(); // FIXED PK name

            // Personal Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('family_name')->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();

            // Membership Details
            $table->string('membership_type', 50)->nullable();
            $table->string('membership_category', 50)->nullable();
            $table->string('role_in_church')->nullable();
            $table->string('baptism_status', 50)->nullable();
            $table->date('date_of_baptism')->nullable();
            $table->date('membership_date')->nullable();

            $table->enum('membership_status', [
                'active', 'inactive', 'transferred', 'archived'
            ])->default('active');

            // Relationships
            $table->uuid('sabbath_school_class_id')->nullable();
            $table->string('photo')->nullable();
            $table->uuid('active_disciplinary_record_id')->nullable();

            // Audit
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['first_name', 'last_name']);
            $table->index('family_name');
            $table->index('membership_status');
            $table->index('sabbath_school_class_id');
            $table->index('email');

            // Foreign Keys
            $table->foreign('sabbath_school_class_id')
                  ->references('id')->on('sabbath_school_classes')
                  ->nullOnDelete();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
