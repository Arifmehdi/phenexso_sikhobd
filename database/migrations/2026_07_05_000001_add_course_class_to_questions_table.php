<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('created_by'); // the course
            $table->unsignedBigInteger('course_lesson_id')->nullable()->after('product_id'); // the class

            $table->index('product_id');
            $table->index('course_lesson_id');
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['product_id']);
            $table->dropIndex(['course_lesson_id']);
            $table->dropColumn(['product_id', 'course_lesson_id']);
        });
    }
};
