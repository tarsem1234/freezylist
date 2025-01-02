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
        Schema::table('property_architecture_conditional_data', function (Blueprint $table) {
            $table->foreign('property_conditional_id', 'property_architecture_conditional_data_ibfk_1')->references('id')->on('property_conditional_data')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('property_architecture_conditional_data', function (Blueprint $table) {
            $table->dropForeign('property_architecture_conditional_data_ibfk_1');
        });
    }
};
