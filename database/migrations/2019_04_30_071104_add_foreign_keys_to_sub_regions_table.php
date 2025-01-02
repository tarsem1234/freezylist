<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sub_regions', function (Blueprint $table) {
            $table->foreign('region_id', 'sub_regions_ibfk_1')->references('id')->on('regions')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_regions', function (Blueprint $table) {
            $table->dropForeign('sub_regions_ibfk_1');
        });
    }
};
