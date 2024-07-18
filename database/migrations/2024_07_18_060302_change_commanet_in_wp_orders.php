<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeCommanetInWpOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_orders', function (Blueprint $table) {
            $table->integer('fullfilled_status')->default(0)->after('status')->comment('0 = Not Fullfilled, 1 = Fullfilled by admin , 2 = Passed to Vendor , 3 Fullfield by Vendor , 4 Reject by Admin , 5 Reject By vendor , 6. Partial Order , 7. cancelled order' )->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_orders', function (Blueprint $table) {
            $table->integer('fullfilled_status')->default(0)->after('status')->comment('0 = Not Fullfilled, 1 = Fullfilled by admin , 2 = Passed to Vendor , 3 Fullfield by Vendor , 4 Reject by Admin , 5 Reject By vendor' )->change();
        });
    }
}
