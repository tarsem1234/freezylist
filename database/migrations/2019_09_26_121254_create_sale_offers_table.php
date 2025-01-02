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
        Schema::create('sale_offers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('property_id')->index('property_id');
            $table->integer('sender_id')->unsigned()->index('sender_id');
            $table->integer('owner_id')->unsigned()->index('owner_id');
            $table->float('tentative_offer_price', 10, 0);
            $table->boolean('closing_cost_requested')->nullable();
            $table->float('percentage_of_price', 10, 0)->nullable();
            $table->float('fixed_amount', 10, 0)->nullable();
            $table->boolean('any_contingencies')->default(0)->comment('1=>yes, 0=>no');
            $table->text('contingencies_explain', 65535)->nullable();
            $table->smallInteger('qualification_document')->nullable();
            $table->string('source_of_cash', 191)->nullable();
            $table->text('optional_message', 65535)->nullable();
            $table->integer('agree');
            $table->string('doc_path', 191)->nullable();
            $table->string('epa', 191)->nullable();
            $table->text('opportunity', 65535)->nullable();
            $table->smallInteger('status')->default(0)->comment('0 => \'pending\', 1 => \'accepted\', 2 => \'rejected_by_seller\', 3 => \'rejected_by_buyer\',\'5\' =>\'User Deleted\'');
            $table->boolean('closed')->default(0)->comment('0=>open, 1=>closed');
            $table->boolean('buyer_signature')->nullable()->default(0)->comment('0 => false 1=> true');
            $table->boolean('seller_signature')->nullable()->default(0)->comment('0 => false 1=> true');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('sale_offers');
    }
};
