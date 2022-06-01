<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZlobeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zlobeks', function (Blueprint $table) {
            $table->id();
            $table->string("Typ instytucji")->nullable();
            $table->string("Nazwa")->nullable();
            $table->string("Lokalizacja instytucji")->nullable();
            $table->string("Adress WWW żłobka/klubu")->nullable();
            $table->string("E-mail żłobka/klubu")->nullable();
            $table->string("phone_num")->nullable();
            $table->integer("places_number")->nullable();
            $table->integer("num_of_children_registrations")->nullable();
            $table->string("monthly_payment")->nullable();
            $table->string("hours_payment_after_10_hours")->nullable();
            $table->string("hours_payment")->nullable();
            $table->string("monthly_payment_for_food")->nullable();
            $table->string("daily_payment_for_food")->nullable();
            $table->string("sales")->nullable();
            $table->string("open_time")->nullable();
            $table->string("is_adapted_for_the_disabled")->nullable();
            $table->string("host_entity_name")->nullable();
            $table->string("host_entity_address")->nullable();
            $table->string("host_entity_nip")->nullable();
            $table->string("host_entity_regon")->nullable();
            $table->string("host_entity_registry_position")->nullable();
            $table->string("host_entity_webpage")->nullable();
            $table->string("does_host_entity_work")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zlobeks');

        $table->dropColumn(["institution_type", "name", "localization", "webpage", "email", "phone_num", "places_number", "num_of_children_registrations", "monthly_payment", "hours_payment_after_10_hours", "hours_payment", "monthly_payment_for_food", "daily_payment_for_food", "sales", "open_time", "is_adapted_for_the_disabled", "host_entity_name", "host_entity_address", "host_entity_nip", "host_entity_regon", "host_entity_registry_position", "host_entity_webpage", "does_host_entity_work"]);
    }
}
