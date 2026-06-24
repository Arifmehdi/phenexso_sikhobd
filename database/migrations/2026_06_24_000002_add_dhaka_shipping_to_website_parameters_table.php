<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_parameters', function (Blueprint $table) {
            $table->decimal('shipping_inside_dhaka', 10, 2)->nullable()->after('shipping_charge');
            $table->decimal('shipping_outside_dhaka', 10, 2)->nullable()->after('shipping_inside_dhaka');
        });
    }

    public function down(): void
    {
        Schema::table('website_parameters', function (Blueprint $table) {
            $table->dropColumn(['shipping_inside_dhaka', 'shipping_outside_dhaka']);
        });
    }
};
