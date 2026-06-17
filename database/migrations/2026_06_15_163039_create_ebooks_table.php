<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('product_categories')->onDelete('set null');
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->string('author_name')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->string('cover_image')->nullable();
            $table->string('file_path')->nullable(); // Full Ebook
            $table->string('preview_path')->nullable(); // Preview part
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->boolean('active')->default(1);
            $table->integer('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebooks');
    }
};
