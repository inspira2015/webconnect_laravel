<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJailImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('jail_import', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source', 2)->nullable();
            $table->integer('check_number')->nullable();
            $table->date('date_1')->nullable(); 
            $table->string('rec_no', 4)->nullable();
            $table->date('date_2')->nullable();
            $table->string('bat_no', 8)->nullable();
            $table->string('def_last_name', 15)->nullable();
            $table->string('def_first_name', 13)->nullable();
            $table->string('def_middle', 13)->nullable();
            $table->string('def_suffix', 3)->nullable();
            $table->string('def_address', 22)->nullable();
            $table->string('def_city', 15)->nullable();
            $table->string('def_state', 3)->nullable();
            $table->string('def_zip', 5)->nullable();
            $table->string('index_no', 10)->nullable();
            $table->integer('court_no')->nullable();
            $table->string('type', 11)->nullable();
            $table->decimal('bail_amt', 10, 2)->nullable();
            $table->string('surety_last_name', 20)->nullable();
            $table->string('surety_first_name', 15)->nullable();
            $table->string('surety_address', 25)->nullable();
            $table->string('surety_city', 15)->nullable();
            $table->string('surety_state', 3)->nullable();
            $table->string('surety_zip', 7)->nullable();
            $table->string('surety_phone', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jail_import');
    }
}
