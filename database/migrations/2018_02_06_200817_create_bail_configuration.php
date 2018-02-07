<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBailConfiguration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bail_configuration', function (Blueprint $table) {
            $table->increments('bc_id');
            $table->string('bc_category', 10);
            $table->string('bc_type', 20);
            $table->string('bc_value', 50)->nullable();
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
        Schema::dropIfExists('bail_configuraion');
    }
}
