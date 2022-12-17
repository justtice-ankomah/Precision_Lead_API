<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ridersLiveLocation', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('deliveryId')->nullable(true);
            $table->foreign('deliveryId')->references('id')->on('deliveries')->onUpdate('id')->onDelete('cascade');
            $table->double("locationLat")->nullable(false);
            $table->double("locationLnt")->nullable(false);
            $table->string("locationName")->nullable(true);;
            $table->longText("locationDesc")->nullable(true);;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ridersLiveLocation');
    }
};


