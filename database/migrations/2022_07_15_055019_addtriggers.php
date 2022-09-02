<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // // trigger to insert delivery details to "deliveries" table automatically
        // // when new item is insterted into "items" table
        // DB::unprepared('DROP TRIGGER IF EXISTS `add_delivery_details`');
        // DB::unprepared('CREATE TRIGGER add_delivery_details AFTER INSERT ON items
        //     FOR EACH ROW
        //     BEGIN
        //         insert into deliveries(customerId,itemId) values(new.customerId, new.id);
        //     END
        // ');

        // // trigger to insert delivery charges to "deliverycharges" table
        // //when new item is inserted into "deliveries" table
        // DB::unprepared('DROP TRIGGER IF EXISTS `add_delivery_charges`');
        // DB::unprepared('CREATE TRIGGER add_delivery_charges AFTER INSERT ON deliveries
        //     FOR EACH ROW
        //     BEGIN
        //         insert into deliverycharges(deliveryid) values(new.id);
        //     END
        // ');

        // // trigger to delete delivery details
        // // when the items table is deleted
        // DB::unprepared('DROP TRIGGER IF EXISTS `delete_delivery_details`');
        // DB::unprepared('CREATE TRIGGER delete_delivery_details AFTER delete ON items
        //     FOR EACH ROW
        //     BEGIN
        //         DELETE FROM deliveries WHERE itemId=old.id;
        //     END
        // ');

        //  // trigger to insert delivery charges to "deliverycharges" table
        // //when new item is inserted into "deliveries" table
        // DB::unprepared('DROP TRIGGER IF EXISTS `delete_delivery_charges`');
        // DB::unprepared('CREATE TRIGGER delete_delivery_charges AFTER delete ON deliveries
        //     FOR EACH ROW
        //     BEGIN
        //         DELETE FROM deliverycharges WHERE deliveryid=old.id
        //     ENDs
        // ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER IF EXISTS `add_delivery_details`');
        // DB::unprepared('DROP TRIGGER IF EXISTS `add_delivery_charges`');
        // DB::unprepared('DROP TRIGGER IF EXISTS `delete_delivery_details`');
        // DB::unprepared('DROP TRIGGER IF EXISTS `delete_delivery_charges`');
    }
};




