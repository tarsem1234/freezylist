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
        Schema::table('users_conditional_data', function (Blueprint $table) {
            $table->dropColumn('seller_signature');
            $table->dropColumn('sender_id');
            $table->dropColumn('owner_id');
            $table->dropColumn('seller_fullname');
            $table->dropColumn('buyer_signature');
            $table->dropColumn('buyer_fullname');
            $table->integer('user_id')->unsigned()->index('sender_id')->after('offer_id');
            $table->string('signature', 191)->after('user_id');
            $table->string('fullname', 255)->after('signature');
            $table->smallInteger('type')->comment('1 => \'buyer\', 2 => \'seller\', 3 => \'cobuyer\', 4 => \'coseller\'')->after('fullname');
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_conditional_data', function (Blueprint $table) {
            $table->integer('sender_id')->unsigned()->index('sender_id')->after('id');
            $table->integer('owner_id')->unsigned()->index('owner_id')->after('sender_id');
            $table->string('buyer_signature', 191)->after('owner_id');
            $table->string('buyer_fullname', 255)->after('buyer_signature');
            $table->string('seller_signature', 191)->after('buyer_fullname');
            $table->string('seller_fullname', 255)->after('seller_signature');
            $table->dropColumn('user_id');
            $table->dropColumn('signature');
            $table->dropColumn('fullname');
            $table->dropColumn('type');
        });
        //
    }
};
