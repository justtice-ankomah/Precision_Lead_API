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
            $table->string("pickUpItemName")->nullable(true);
            $table->string("pickUpItemCategory")->nullable(true)->default(null);
            $table->longText("pickUpItemDesc")->nullable(true);
            $table->string("deliveryCode")->nullable(false)->unique();
            $table->string("couponCode")->nullable(true);
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
            $table->string("paymentType")->nullable(true)->default('INSTANT'); // [INSTANT, PAY ON DELIVERY]
            $table->integer("totalCostAmount")->nullable()->default(null);
            $table->integer("discountAmount")->nullable(true)->default(null);
            $table->integer("deliveryCostAmount")->nullable(false);
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
            $table->string("didUserBuyProduct")->nullable(false)->default("NO"); // [YES, NO]
            // $table->longText("productList")->nullable(true)->default(null);
            $table->json("productList")->nullable(true)->default(null);
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


