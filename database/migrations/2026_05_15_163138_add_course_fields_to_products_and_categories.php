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
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->default('product')->after('id'); // product, course
            $table->string('duration')->nullable()->after('selling_price');
            $table->integer('lessons_count')->default(0)->after('duration');
            $table->string('level')->nullable()->after('lessons_count'); // beginner, intermediate, advanced
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('type')->default('product')->after('id'); // product, course
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'duration', 'lessons_count', 'level']);
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
