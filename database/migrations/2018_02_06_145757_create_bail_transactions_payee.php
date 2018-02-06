<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBailTransactionsPayee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('bail_transactions_payee', function (Blueprint $table) {
            $table->increments('p_id');
            $table->integer('t_id');
            $table->dateTime('p_process_date')->nullable(); 
            $table->string('p_check_number', 12)->nullable();
            $table->decimal('p_check_amount', 12, 2)->nullable(); 
            $table->string('p_name', 50)->nullable(); 
            $table->string('p_care_of', 50)->nullable(); 
            $table->string('p_address', 50)->nullable(); 
            $table->string('p_city', 20)->nullable(); 
            $table->string('p_state', 3)->nullable(); 
            $table->string('p_zip', 5)->nullable(); 
            $table->string('p_zip_suffix', 4)->nullable(); 
            $table->string('p_check_notes', 50)->nullable(); 
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
