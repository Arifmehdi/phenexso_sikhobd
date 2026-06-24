<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');           // the course
            $table->unsignedBigInteger('enrollment_id')->nullable();
            $table->decimal('final_score', 5, 2)->nullable();   // best exam score % (optional)
            $table->timestamp('issued_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'product_id']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
