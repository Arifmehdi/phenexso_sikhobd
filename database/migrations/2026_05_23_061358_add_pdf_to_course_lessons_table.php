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
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->string('pdf_url')->nullable()->after('video_url');
            $table->string('audio_url')->nullable()->after('pdf_url');
            $table->string('video_file')->nullable()->after('audio_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_lessons', function (Blueprint $table) {
            $table->dropColumn(['pdf_url', 'audio_url', 'video_file']);
        });
    }
};
