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
         Schema::create('bail_master', function (Blueprint $table) {
            $table->increments('m_id');
            $table->integer('m_court_number');
            $table->string('m_index_number', 10);
            $table->string('m_index_year', 2);
            $table->date('m_posted_date')->nullable(); 
            $table->string('m_def_last_name', 20)->nullable();
            $table->string('m_def_first_name', 20)->nullable();
            $table->string('m_surety_last_name', 20)->nullable();
            $table->string('m_surety_first_name', 20)->nullable();
            $table->decimal('m_forfeit_amount', 18, 2)->nullable();
            $table->decimal('m_payment_amount', 18, 2)->nullable();
            $table->decimal('m_city_fee_amount', 18, 2)->nullable();
            $table->decimal('m_receipt_amount', 18, 2)->nullable();
            $table->string('m_comments_ind', 1)->nullable();   // whats the difference between this 2 comments
            $table->string('m_status', 1)->nullable();
            $table->string('m_surety_address', 40)->nullable(); 
            $table->string('m_surety_city', 20)->nullable(); 
            $table->string('m_surety_state', 2)->nullable(); 
            $table->string('m_surety_zip', 10)->nullable(); 
            $table->integer('m_flag_forfeit')->nullable(); 
            $table->date('m_flag_date')->nullable(); 
            $table->date('m_date_of_record')->nullable(); 
            $table->string('m_numis_doc_id', 12)->nullable(); 
            $table->longText('m_comments');                   // Another comment
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
        Schema::dropIfExists('bail_master');
    }
}
