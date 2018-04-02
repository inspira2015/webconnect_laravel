<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBailForfeitures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bail_forfeitures', function (Blueprint $table) {
            $table->increments('bf_id');
            $table->dateTime('bf_create_at');
            $table->dateTime('bf_updated_at');
            $table->integer('m_id');
            $table->integer('bf_active');
            $table->integer('bf_processed');
            $table->integer('user_id');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bail_forfeitures');
    }
}
