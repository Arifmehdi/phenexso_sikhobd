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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('student_class')->nullable();
            $table->string('occupation')->nullable();
            $table->string('last_academic_status')->nullable();
            $table->boolean('has_course')->default(false);
            $table->string('admin_approval')->default('pending'); // pending, approved, rejected
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['student_class', 'occupation', 'last_academic_status', 'has_course', 'admin_approval']);
        });
    }
};
