<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->index(['quiz_id', 'student_id']);
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->index('course_id');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->index(['conversation_id', 'created_at']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->index('course_id');
            $table->index('teacher_id');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropIndex(['quiz_id', 'student_id']);
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->dropIndex(['course_id']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['conversation_id', 'created_at']);
        });

        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex(['course_id']);
            $table->dropIndex(['teacher_id']);
        });
    }
};
