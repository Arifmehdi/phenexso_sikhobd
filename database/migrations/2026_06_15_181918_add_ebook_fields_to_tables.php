<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('ebook_id')->nullable()->after('product_id')->constrained('ebooks')->onDelete('cascade');
        });

        // Use raw SQL to make product_id nullable to avoid Doctrine DBAL dependency
        DB::statement('ALTER TABLE carts MODIFY product_id BIGINT UNSIGNED NULL');

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('ebook_id')->nullable()->after('product_id')->constrained('ebooks')->onDelete('set null');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('has_ebook')->default(0)->after('has_course');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['ebook_id']);
            $table->dropColumn('ebook_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['ebook_id']);
            $table->dropColumn('ebook_id');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('has_ebook');
        });
    }
};
