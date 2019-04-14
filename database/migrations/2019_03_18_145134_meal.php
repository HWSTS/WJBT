<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Meal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('res_id',50);
            $table->string('meal_id',50)->unique();
            $table->unsignedInteger('province')->default(0);
            $table->unsignedInteger('category')->default(0);
            $table->string('name',50);
            $table->string('price',20);
            $table->string('img_url',200)->default('http://192.168.1.171/Wajabat/public/images/meal3.jpg');
            $table->string('num_person',20)->default('1');
            $table->unsignedInteger('num_orders')->default(5);
            $table->string('delv_time',20)->default('30');
            $table->string('discount',20)->default('0');
            $table->text('ar_ing');
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
