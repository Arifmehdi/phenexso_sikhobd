<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->unsignedBigInteger('exam_id')->nullable()->after('product_id');
            $table->string('type')->default('course')->after('exam_id'); // course | exam
            $table->index('exam_id');
        });

        // product_id is only required for course certificates
        DB::statement('ALTER TABLE certificates MODIFY product_id BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['exam_id', 'type']);
        });
    }
};
