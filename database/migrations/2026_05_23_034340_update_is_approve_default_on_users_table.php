<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $row) {
            $row->boolean('is_approve')->default(0)->change();
        });

        // Set existing users to approved
        User::whereNull('is_approve')->update(['is_approve' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $row) {
            $row->boolean('is_approve')->nullable()->default(null)->change();
        });
    }
};
