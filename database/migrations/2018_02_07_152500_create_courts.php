<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('courts', function (Blueprint $table) {
            $table->increments('c_id');
            $table->string('c_name', 20);
            $table->string('c_address', 80)->nullable();
            $table->string('c_city', 80)->nullable();
            $table->string('c_state', 3)->nullable();
            $table->string('c_zip', 5)->nullable();
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
        Schema::dropIfExists('log');
    }
}
