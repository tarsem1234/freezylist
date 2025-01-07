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
        Schema::create('property_condition_disclaimer', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('property_id')->index('property_id');
            $table->integer('user_id')->unsigned()->index('user_id');
            $table->smallInteger('property_age');
            $table->string('date_added');
            $table->boolean('occupy');
            $table->string('how_long')->nullable();
            $table->boolean('property_is');
            $table->string('roof_type');
            $table->integer('roof_age');
            $table->boolean('house_owners_associations')->nullable();
            $table->text('name_address', 65535)->nullable();
            $table->float('monthly_dues', 10, 0)->nullable();
            $table->float('transfer_fees', 10, 0)->nullable();
            $table->string('special_assessments')->nullable();
            $table->text('property_includes', 65535)->nullable();
            $table->smallInteger('how_many')->nullable();
            $table->boolean('pool_type')->nullable();
            $table->boolean('garage_type')->nullable();
            $table->smallInteger('how_many_remotes')->nullable();
            $table->integer('heat_pump_age')->nullable();
            $table->integer('central_heating_age')->nullable();
            $table->string('central_heating_type', 191)->nullable();
            $table->integer('central_air_conditioning_age')->nullable();
            $table->string('central_air_conditioning_type')->nullable();
            $table->integer('water_heater_age')->nullable();
            $table->string('water_heater_type')->nullable();
            $table->string('water_supply_type')->nullable();
            $table->string('sewage_disposal_type')->nullable();
            $table->string('gas_supply_type')->nullable();
            $table->text('other_items_included', 65535)->nullable();
            $table->boolean('best_knowledge');
            $table->text('best_knowledge_explain', 65535)->nullable();
            $table->boolean('interior_walls');
            $table->boolean('ceilings');
            $table->boolean('floors');
            $table->boolean('windows');
            $table->boolean('doors');
            $table->boolean('insulation');
            $table->boolean('plumbing');
            $table->boolean('sewer');
            $table->boolean('electrical_system');
            $table->boolean('exterior_walls');
            $table->boolean('roof');
            $table->boolean('basement');
            $table->boolean('foundation');
            $table->boolean('slab');
            $table->boolean('drive_way');
            $table->boolean('side_walks');
            $table->boolean('central_heating');
            $table->boolean('heat_pump');
            $table->boolean('central_air');
            $table->text('partb_details', 65535)->nullable();
            $table->text('any_repairs', 65535)->nullable();
            $table->boolean('substances');
            $table->boolean('features_shared');
            $table->boolean('any_authorized_changes');
            $table->text('most_recent_survey', 65535)->nullable();
            $table->boolean('any_change_since_latest_survey');
            $table->boolean('any_encroachments');
            $table->boolean('repairs');
            $table->boolean('repairs_with_building_codes');
            $table->boolean('land_fill');
            $table->boolean('any_settling');
            $table->boolean('problems');
            $table->boolean('requirement');
            $table->boolean('location');
            $table->boolean('interior');
            $table->boolean('structural_damage');
            $table->boolean('any_zoning_violations');
            $table->boolean('neighborhood_noise');
            $table->boolean('restrictions');
            $table->boolean('any_common_area');
            $table->boolean('any_notices');
            $table->boolean('any_lawsuit');
            $table->boolean('any_system');
            $table->boolean('any_exterior');
            $table->boolean('any_finished_rooms');
            $table->integer('septic_tank_for_bedrooms')->nullable();
            $table->boolean('any_septic_tank');
            $table->boolean('affected');
            $table->boolean('in_an_historical_district');
            $table->text('partc_details', 65535)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->text('html')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('property_condition_disclaimer');
    }
};
