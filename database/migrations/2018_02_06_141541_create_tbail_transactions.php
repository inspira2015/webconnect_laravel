<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbailTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bail_transactions', function (Blueprint $table) {
            $table->increments('t_id');
            $table->integer('m_id');
            $table->string('t_numis_doc_id', 12)->nullable(); 
            $table->dateTime('t_created_at')->nullable(); 
            $table->string('t_debit_credit_ind', 2)->nullable();
            $table->string('t_type', 5)->nullable();
            $table->decimal('t_amount', 18, 2)->nullable();
            $table->decimal('t_fee_percentage', 10, 2)->nullable();
            $table->decimal('t_total_refund', 18, 2)->nullable();
            $table->string('t_reversal_index', 2)->nullable();
            $table->string('t_check_number', 15)->nullable();
            $table->dateTime('t_date_check_paid')->nullable(); 
            $table->string('t_mult_check_index', 2)->nullable();
            $table->dateTime('t_last_update')->nullable(); 
            $table->string('t_last_update_user', 20)->nullable();
            $table->string('t_multi_court_number', 50)->nullable();
            $table->string('t_no_reversal', 50)->nullable();
            $table->longText('t_comments');
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
        Schema::dropIfExists('bail_transactions');
    }
}
