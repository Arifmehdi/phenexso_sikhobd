<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreignId('ebook_id')->nullable()->after('product_id')->constrained('ebooks')->onDelete('cascade');
        });

        // Use raw SQL to make product_id nullable to avoid Doctrine DBAL dependency
        DB::statement('ALTER TABLE enrollments MODIFY product_id BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropForeign(['ebook_id']);
            $table->dropColumn('ebook_id');
        });
    }
};
