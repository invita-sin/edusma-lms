<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->index('score');
            $table->index('submitted_at');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->index('date');
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::table('assignment_submissions', function (Blueprint $table) {
            $table->dropIndex(['score']);
            $table->dropIndex(['submitted_at']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['date']);
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['subject_type', 'subject_id']);
        });
    }
};
