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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("price")->nullable(false);
            $table->string("name")->nullable(false);
            $table->longText("description")->nullable(true);
            $table->unsignedBigInteger("productCategoryID")->nullable(false);
            $table->foreign('productCategoryID')->references('id')->on('productcategories')->onUpdate('cascade')->onDelete('cascade');
            $table->longText("productImageUrls")->nullable(false);
            $table->integer("quantityAvailable")->nullable(false);
            $table->unsignedBigInteger('addedByAdminId')->nullable(false);
            $table->foreign('addedByAdminId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
