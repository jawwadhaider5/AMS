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
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('dimension')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spread_category', function (Blueprint $table) {
            $table->dropColumn('size');
            $table->dropColumn('weight');
            $table->dropColumn('height');
            $table->dropColumn('dimension');
        });
    }
};
