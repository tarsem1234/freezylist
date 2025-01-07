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
        Schema::table('signatures', function (Blueprint $table) {
            $table->smallInteger('signature_type')->nullable()->change();
            $table->string('fullname', 255)->after('signature');
            $table->smallInteger('type')->comment('1 => \'buyer\', 2 => \'seller\', 3 => \'cobuyer\', 4 => \'coseller\'')->after('fullname');
            $table->smallInteger('affix_status')->comment('0 => \'signature not done\', 1 => \'signature done\'')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        $table->smallInteger('signature_type')->change();
        $table->dropColumn('fullname');
        $table->dropColumn('type');
        $table->dropColumn('affix_status');
    }
};
