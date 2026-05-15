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
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title_en');
            $table->string('title_bn')->nullable();
            $table->text('description')->nullable();
            $table->string('video_provider')->default('youtube'); // youtube, vimeo, custom
            $table->string('video_url')->nullable();
            $table->string('duration')->nullable();
            $table->integer('priority')->default(0);
            $table->boolean('is_free')->default(false);
            $table->boolean('active')->default(true);
            $table->foreignId('addedby_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
