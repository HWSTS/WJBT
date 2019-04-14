<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_location', function (Blueprint $table) {
            $table->increments('id');
            $table->string('res_id',50);
            $table->unsignedInteger('province')->default(0);
            $table->string('name',50);
            $table->decimal('lat', 10, 7)->default(0000000000);
            $table->decimal('long', 10, 7)->default(0000000000);
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
