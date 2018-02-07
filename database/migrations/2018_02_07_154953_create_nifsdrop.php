<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNifsdrop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('nifsdrop', function (Blueprint $table) {
            $table->increments('n_id');
            $table->string('SUBSYS-ID', 2);
            $table->string('RECORD-TYPE', 2);
            $table->string('INPUT-MO', 2);
            $table->string('INPUT-YR', 4);
            $table->string('TRANS-CODE', 3);
            $table->string('TRANS-SUFFIX', 1);
            $table->string('DOC-TYPE', 2);
            $table->string('DOC-DATE', 8);
            $table->string('DISCOUNT-DATE', 8);
            $table->string('DOCUMENT-NUMBER', 12);
            $table->string('DOCUMENT-SUFFIX', 2);
            $table->string('REFERENCE-NUMBER', 12);
            $table->string('REFERENCE-SUFFIX', 2);
            $table->string('BANK-NO', 6);
            $table->string('TREAS-NO', 8);
            $table->string('GL-ACCT', 6);
            $table->string('SUBSID-NO', 6);
            $table->string('VENDOR-NO', 10);
            $table->string('VENDOR-SUFFIX', 2);
            $table->string('SINGLE-CHK-IND', 1);
            $table->string('INDEX-CODE', 12);
            $table->string('SUBOBJECT', 6);
            $table->string('USER-CODE', 8);
            $table->string('GRANT-LVL-1', 6);
            $table->string('GRANT-LVL-2', 6);
            $table->string('PROJECT-LVL-1', 6);
            $table->string('PROJECT-LVL-2', 6);
            $table->string('TRANS-AMT', 17);
            $table->string('TRANS-AMT-NET', 17);
            $table->string('TRANS-DESC', 50);
            $table->string('CURRENCY-CODE', 3);
            $table->string('CONV-DATE', 8);
            $table->string('FC-TRANS-AMT', 17);
            $table->string('PST-IND', 1);
            $table->string('PST-RATE', 1);
            $table->string('GST-IND', 1);
            $table->string('GST-RATE', 1);
            $table->string('QUANTITY', 11);
            $table->string('UNIT-OF-MEASURE', 5);
            $table->string('UNIT-PRICE', 13);
            $table->string('TERMS', 10);
            $table->string('OPER-ID', 8);
            $table->string('PESP-UNIT', 3);
            $table->string('VENDOR-NAME', 40);
            $table->string('ADDRESS-1', 40);
            $table->string('ADDRESS-2', 40);
            $table->string('ADDRESS-CITY', 25);
            $table->string('ADDRESS-STATE', 2);
            $table->string('ADDRESS-ZIP', 11);
            $table->string('COUNTRY-CODE', 3);
            $table->string('ALPHA-SORT', 25);
            $table->string('BUS-TAX-NO', 9);
            $table->string('FEDTAX-SSN-IND', 1);
            $table->string('1099-IND', 1);
            $table->string('FILLER', 38);
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
        Schema::dropIfExists('nifsdrop');
    }
}
