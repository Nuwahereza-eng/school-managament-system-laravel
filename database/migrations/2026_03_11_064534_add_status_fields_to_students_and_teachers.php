<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add status field to students table
        Schema::table('students', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'graduated', 'transferred', 'suspended'])->default('active')->after('enrollment_date');
            $table->text('notes')->nullable()->after('status');
        });

        // Add status field to teachers table
        Schema::table('teachers', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive', 'on_leave', 'terminated'])->default('active')->after('gender');
            $table->date('hire_date')->nullable()->after('status');
            $table->string('qualification')->nullable()->after('hire_date');
            $table->string('specialization')->nullable()->after('qualification');
        });

        // Add capacity to classrooms
        Schema::table('classrooms', function (Blueprint $table) {
            $table->integer('capacity')->default(30)->after('description');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('capacity');
        });

        // Add credits to subjects
        Schema::table('subjects', function (Blueprint $table) {
            $table->integer('credits')->default(3)->after('semester');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('credits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['status', 'notes']);
        });

        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['status', 'hire_date', 'qualification', 'specialization']);
        });

        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'status']);
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn(['credits', 'status']);
        });
    }
};
