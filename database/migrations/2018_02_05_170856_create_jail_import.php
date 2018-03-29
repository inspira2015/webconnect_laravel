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
            $table->increments('j_id');
            $table->dateTime('created_at')->nullable();
            $table->string('j_source', 2)->nullable();
            $table->integer('j_check_number')->nullable();
            $table->date('j_date_1')->nullable(); // what is date for?
            $table->string('j_rec_number', 4)->nullable(); // what is rec means?
            $table->date('j_date_2')->nullable();   // what is date 2 for ?
            $table->string('j_bat_number', 8)->nullable(); // bat?
            $table->string('j_def_last_name', 15)->nullable();
            $table->string('j_def_first_name', 13)->nullable();
            $table->string('j_def_middle', 13)->nullable();
            $table->string('j_def_suffix', 3)->nullable();
            $table->string('j_def_address', 22)->nullable();
            $table->string('j_def_city', 15)->nullable();
            $table->string('j_def_state', 3)->nullable();
            $table->string('j_def_zip', 5)->nullable();
            $table->string('j_index_number', 10)->nullable();
            $table->integer('j_court_number')->nullable();
            $table->string('j_type', 11)->nullable();
            $table->decimal('j_bail_amount', 10, 2)->nullable();
            $table->string('j_surety_last_name', 20)->nullable();
            $table->string('j_surety_first_name', 15)->nullable();
            $table->string('j_surety_address', 25)->nullable();
            $table->string('j_surety_city', 15)->nullable();
            $table->string('j_surety_state', 3)->nullable();
            $table->string('j_surety_zip', 7)->nullable();
            $table->string('j_surety_phone', 10)->nullable();
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
