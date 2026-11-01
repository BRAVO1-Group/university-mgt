<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unique('user_id');
        });

        Schema::table('lecturers', function (Blueprint $table) {
            $table->unique('user_id');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->index(['academic_year', 'semester']);
        });

        Schema::table('course_registrations', function (Blueprint $table) {
            $table->index(['course_id', 'academic_year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::table('course_registrations', function (Blueprint $table) {
            $table->dropIndex(['course_id', 'academic_year', 'semester']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropIndex(['academic_year', 'semester']);
        });

        Schema::table('lecturers', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
