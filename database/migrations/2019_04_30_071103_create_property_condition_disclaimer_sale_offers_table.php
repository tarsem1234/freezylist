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
        Schema::create('property_condition_disclaimer_sale_offers', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('title');
            $table->integer('property_id')->index('property_id');
            $table->integer('sale_offer_id')->index('sale_offer_id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('property_age');
            $table->string('date_added');
            $table->string('occupy');
            $table->string('how_long');
            $table->string('property_is');
            $table->string('roof_type');
            $table->string('roof_age');
            $table->string('house_owners_associations');
            $table->text('name_address', 65535);
            $table->string('monthly_dues');
            $table->string('transfer_fees');
            $table->string('special_assessments');
            $table->text('property_includes', 65535);
            $table->string('how_many');
            $table->string('pool');
            $table->string('garage');
            $table->string('how_many_remotes');
            $table->string('heat_pump_age');
            $table->string('central_heating_age');
            $table->string('central_air_conditioning_age');
            $table->string('water_heater_age');
            $table->string('other_items_included');
            $table->string('bs_knowledge');
            $table->string('bs_knowledge_details');
            $table->string('interior_walls');
            $table->string('ceilings');
            $table->string('floors');
            $table->string('windows');
            $table->string('doors');
            $table->string('insulation');
            $table->string('plumbing');
            $table->string('sewer');
            $table->string('electrical_system');
            $table->string('exterior_walls');
            $table->string('roof');
            $table->string('basement');
            $table->string('foundation');
            $table->string('slab');
            $table->string('drive_way');
            $table->string('side_walks');
            $table->string('central_heating');
            $table->string('heat_pump');
            $table->string('central_air');
            $table->string('partb_details');
            $table->string('any_repairs');
            $table->string('substances');
            $table->string('features_shared');
            $table->string('any_authorized_changes');
            $table->string('most_recent_survey');
            $table->string('any_change_since_latest_survey');
            $table->string('any_encroachments');
            $table->string('repairs');
            $table->string('repairs_with_building_codes');
            $table->string('land_fill');
            $table->string('any_settling');
            $table->string('problems');
            $table->string('requirement');
            $table->string('location');
            $table->string('interior');
            $table->string('structural_damage');
            $table->string('any_zoning_violations');
            $table->string('neighborhood_noise');
            $table->string('restrictions');
            $table->string('any_common_area');
            $table->string('any_notices');
            $table->string('any_lawsuit');
            $table->string('any_system');
            $table->string('any_exterior');
            $table->string('any_finished_rooms');
            $table->string('legally_permitted_for', 50);
            $table->string('any_septic_tank');
            $table->string('affected');
            $table->string('in_an_historical_district');
            $table->string('partc_details');
            $table->string('seller_signature');
            $table->string('seller_date_time', 500);
            $table->string('buyer_signature');
            $table->string('buyer_date_time', 500);
            $table->timestamps();
            $table->softDeletes();
            $table->text('html');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('property_condition_disclaimer_sale_offers');
    }
};
