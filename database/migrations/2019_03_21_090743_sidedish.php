<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sidedish extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidedish', function (Blueprint $table) {
            $table->increments('id');
            $table->string('meal_id',50)->unique();
            $table->unsignedInteger('pepsi')->default(0);
            $table->unsignedInteger('fries')->default(0);
            $table->unsignedInteger('entree')->default(0);
            $table->unsignedInteger('sauce')->default(0);
            $table->unsignedInteger('juice')->default(0);
            $table->unsignedInteger('saop')->default(0);
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
