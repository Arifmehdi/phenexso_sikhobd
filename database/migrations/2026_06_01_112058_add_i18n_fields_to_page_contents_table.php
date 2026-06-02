<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('page_slug');
            $table->string('title_bn')->nullable()->after('title_en');
            $table->text('subtitle_en')->nullable()->after('subtitle');
            $table->text('subtitle_bn')->nullable()->after('subtitle_en');
            $table->text('description_en')->nullable()->after('description');
            $table->text('description_bn')->nullable()->after('description_en');
            $table->text('content_en')->nullable()->after('content');
            $table->text('content_bn')->nullable()->after('content_en');
        });
    }

    public function down()
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn([
                'title_en', 'title_bn',
                'subtitle_en', 'subtitle_bn',
                'description_en', 'description_bn',
                'content_en', 'content_bn'
            ]);
        });
    }
};
