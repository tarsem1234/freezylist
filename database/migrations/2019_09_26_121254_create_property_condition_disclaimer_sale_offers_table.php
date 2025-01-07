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
            $table->string('title', 191);
            $table->integer('property_id')->index('property_id');
            $table->integer('sale_offer_id')->index('sale_offer_id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->string('property_age', 191);
            $table->string('date_added', 191);
            $table->string('occupy', 191);
            $table->string('how_long', 191);
            $table->string('property_is', 191);
            $table->string('roof_type', 191);
            $table->string('roof_age', 191);
            $table->string('house_owners_associations', 191);
            $table->text('name_address', 65535);
            $table->string('monthly_dues', 191);
            $table->string('transfer_fees', 191);
            $table->string('special_assessments', 191);
            $table->text('property_includes', 65535);
            $table->string('how_many', 191);
            $table->string('pool', 191);
            $table->string('garage', 191);
            $table->string('how_many_remotes', 191);
            $table->string('heat_pump_age', 191);
            $table->string('central_heating_age', 191);
            $table->string('central_air_conditioning_age', 191);
            $table->string('water_heater_age', 191);
            $table->string('other_items_included', 191);
            $table->string('bs_knowledge', 191);
            $table->string('bs_knowledge_details', 191);
            $table->string('interior_walls', 191);
            $table->string('ceilings', 191);
            $table->string('floors', 191);
            $table->string('windows', 191);
            $table->string('doors', 191);
            $table->string('insulation', 191);
            $table->string('plumbing', 191);
            $table->string('sewer', 191);
            $table->string('electrical_system', 191);
            $table->string('exterior_walls', 191);
            $table->string('roof', 191);
            $table->string('basement', 191);
            $table->string('foundation', 191);
            $table->string('slab', 191);
            $table->string('drive_way', 191);
            $table->string('side_walks', 191);
            $table->string('central_heating', 191);
            $table->string('heat_pump', 191);
            $table->string('central_air', 191);
            $table->string('partb_details', 191);
            $table->string('any_repairs', 191);
            $table->string('substances', 191);
            $table->string('features_shared', 191);
            $table->string('any_authorized_changes', 191);
            $table->string('most_recent_survey', 191);
            $table->string('any_change_since_latest_survey', 191);
            $table->string('any_encroachments', 191);
            $table->string('repairs', 191);
            $table->string('repairs_with_building_codes', 191);
            $table->string('land_fill', 191);
            $table->string('any_settling', 191);
            $table->string('problems', 191);
            $table->string('requirement', 191);
            $table->string('location', 191);
            $table->string('interior', 191);
            $table->string('structural_damage', 191);
            $table->string('any_zoning_violations', 191);
            $table->string('neighborhood_noise', 191);
            $table->string('restrictions', 191);
            $table->string('any_common_area', 191);
            $table->string('any_notices', 191);
            $table->string('any_lawsuit', 191);
            $table->string('any_system', 191);
            $table->string('any_exterior', 191);
            $table->string('any_finished_rooms', 191);
            $table->string('legally_permitted_for', 50);
            $table->string('any_septic_tank', 191);
            $table->string('affected', 191);
            $table->string('in_an_historical_district', 191);
            $table->string('partc_details', 191);
            $table->string('seller_signature', 191);
            $table->string('seller_date_time', 500);
            $table->string('buyer_signature', 191);
            $table->string('buyer_date_time', 500);
            $table->timestamps();
            $table->softDeletes();
            $table->text('html', 65535);
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
