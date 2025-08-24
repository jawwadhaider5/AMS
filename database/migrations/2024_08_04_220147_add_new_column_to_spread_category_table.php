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
        Schema::table('spread_category', function (Blueprint $table) {
            $table->string('data_sheet')->nullable();
            $table->string('certificates')->nullable();
            $table->string('manual')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spread_category', function (Blueprint $table) {
            $table->dropColumn([
                'data_sheet',
                'certificates',
                'manual'
            ]);
        });
    }
};
