<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Restaurant extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('res_id',50)->unique();
            $table->string('name',50);
            $table->unsignedInteger('province')->default(0);
            $table->string('img_url',200);
            $table->string('contact_number',20);
            $table->string('open_time',50)->default('11:00 AM - 1:00 AM');
            $table->string('username');
            $table->string('password');
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
