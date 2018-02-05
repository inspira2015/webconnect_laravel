<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbailMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('tbail_master', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('court_no');
            $table->string('index_no', 10);
            $table->string('index_year', 2);
            $table->date('posted_date')->nullable(); 
            $table->string('def_last_name', 20)->nullable();
            $table->string('def_first_name', 20)->nullable();
            $table->string('surety_last_name', 20)->nullable();
            $table->string('surety_first_name', 20)->nullable();
            $table->decimal('total_forfeit_amt', 18, 2)->nullable();
            $table->decimal('total_payment_amt', 18, 2)->nullable();
            $table->decimal('total_cty_fee_amt', 18, 2)->nullable();
            $table->decimal('total_receipt_amt', 18, 2)->nullable();
            $table->string('comments_ind', 1)->nullable();
            $table->string('bail_status', 1)->nullable();
            $table->string('surety_address', 40)->nullable(); 
            $table->string('surety_city', 20)->nullable(); 
            $table->string('surety_state', 2)->nullable(); 
            $table->string('surety_zip', 10)->nullable(); 
            $table->integer('flag_forfeit')->nullable(); 
            $table->date('flag_date')->nullable(); 
            $table->date('date_of_record')->nullable(); 
            $table->string('NUMIS_doc_id', 12)->nullable(); 
            $table->longText('comments');
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
        Schema::dropIfExists('tbail_master');
    }
}
