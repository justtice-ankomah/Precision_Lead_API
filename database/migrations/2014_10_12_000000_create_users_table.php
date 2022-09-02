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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('groupid');
            $table->string('fullname')->nullable(false);
            $table->string('username')->nullable(false)->unique();
            $table->string('phonenumber')->unique()->nullable(false);
            $table->string('profileUrl')->unique()->nullable(true);
            $table->string('momonumber')->nullable(true);
            $table->string('address')->nullable(false);
            $table->boolean("isUserBlocked")->nullable(false)->default(false);
            $table->string('password')->nullable(false);
            $table->timestamp('phonenumber_verified_at')->nullable();
            $table->string("locationLat")->nullable(true);
            $table->string("locationLnt")->nullable(true);
            $table->string("locationName")->nullable(true);
            $table->longText("locationDesc")->nullable(true);
            $table->timestamps();
            $table->foreign('groupid')->references('id')->on('usersgroupid')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
