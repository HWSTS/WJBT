<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
        $table->increments('id');
        $table->string('oid',8);
        $table->string('user_id',50);
        $table->string('res_id',50);
        $table->string('meal_id',50);
        $table->unsignedInteger('qty')->default(1);
        $table->string('price',20);
        $table->string('subtotal',20);
        $table->string('user_location');
        $table->string('user_number',20);
        $table->unsignedInteger('status')->default(0);
        $table->unsignedInteger('pay_status')->default(0);
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
        //
    }
}
