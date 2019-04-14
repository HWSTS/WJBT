<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',50)->unique();
            $table->string('contact_number',20);
            $table->unsignedInteger('code');
            $table->unsignedInteger('province')->default(0);
            $table->unsignedInteger('attempts')->default(1);
            $table->unsignedInteger('suspended')->default(0);
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
