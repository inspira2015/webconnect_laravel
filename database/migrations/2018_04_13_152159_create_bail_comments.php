<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBailComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bail_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('foreign_table', 25);
            $table->integer('foreign_id');
            $table->longText('comment');
            $table->integer('user_id');
            $table->dateTime('created_at');
            $table->softDeletes();
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
        Schema::dropIfExists('bail_comments');
    }
}
