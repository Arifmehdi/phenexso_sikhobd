<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_parameters', function (Blueprint $table) {
            $table->text('footer_about_en')->nullable()->after('about_subtitle');
            $table->text('footer_about_bn')->nullable()->after('footer_about_en');
        });
    }

    public function down(): void
    {
        Schema::table('website_parameters', function (Blueprint $table) {
            $table->dropColumn(['footer_about_en', 'footer_about_bn']);
        });
    }
};
