<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_ves'); // se renseigner
            $table->string('description');
            $table->integer('weight_empty_kg');
            $table->integer('electric_power_kw');
            $table->integer('max_speed');
            $table->integer('scx'); // se renseigner
            $table->integer('cr'); // coefficientrollingresistance
            $table->integer('battery_kwh');
            $table->string('picture');
            $table->integer('rdtBattDeCharge'); //used twice in create // se renseigner
            $table->integer('rdtBattCharge');// used as rdtBattCharge in edit // se renseigner
            $table->integer('rdtMoteur');// se renseigner
    		    $table->integer('precup');// se renseigner
    		    $table->string('note');
    		    $table->integer('category_id')->unsigned(); //unsigned because id is unsigned by default
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
