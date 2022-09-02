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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string("status")->nullable()->default("UNACCEPTED"); // [ACCEPTED, UNACCEPTED, FAILED, PENDING, PASSED, "DECLINED"]
            $table->string("deliveryType")->nullable(false); // [INCOMING, OUTGOING]
            $table->string("itemName")->nullable(false);
            $table->string("itemCategory")->nullable()->default(null);
            $table->longText("itemDesc")->nullable(true);
            $table->string("itemCode")->nullable(false)->unique();
            $table->unsignedBigInteger('senderId')->nullable(false);
            $table->foreign('senderId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('receiverId')->nullable(true);
            $table->foreign('receiverId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // Only require below 3 fields when deliverying to someone
            $table->string("receiverName")->nullable(true);
            $table->string("reciverContact")->nullable(true);
            $table->string("reciverIdNumber")->nullable(true);
            $table->unsignedBigInteger("riderId")->nullable(false);
            $table->foreign('riderId')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('isDelvStarted')->default("NO");  // [NO, YES]
            $table->dateTime('delvStartDate')->nullable();
            $table->dateTime('delvEndDate')->nullable();
            $table->string("paymentMethod")->nullable()->default(null); // [MOMO, CARD]
            $table->integer("costAmount")->nullable()->default(null);
            $table->string("paymentstatus")->nullable()->default("UNPAID"); // [UNPAID, PAID]
            $table->string("pickUpLocationLat")->nullable(false);
            $table->string("pickUpLocationLnt")->nullable(false);
            $table->string("pickUpLocationName");
            $table->longText("pickUpLocationDesc");
            $table->string("destLocationLat")->nullable(false);
            $table->string("destLocationLnt")->nullable(false);
            $table->string("destLocationName");
            $table->longText("destLocationDesc");
            // I just added below two
            $table->unsignedBigInteger('productId')->nullable(true);
            $table->foreign('productId')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->string("didUserBuyProduct")->nullable(false)->default("NO"); // [YES, NO]
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
        Schema::dropIfExists('deliveries');
    }
};


