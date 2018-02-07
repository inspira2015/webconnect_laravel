<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('batch_approvals', function (Blueprint $table) {
            $table->increments('ba_id');
            $table->integer('bg_id');
            $table->dateTime('ba_create_at');
            $table->integer('ba_sent_user_id');
            $table->integer('ba_approve_user_id');
            $table->dateTime('ba_approved_at');
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
        Schema::dropIfExists('batch_approvals');
    }
}
