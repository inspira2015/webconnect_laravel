<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JailImport;
use DB;

class ImportDataController extends Controller
{
 
    public function importOldJailTable()
    {
        $jailimport = DB::connection('mysql2')->table('jailimport')->get();

        foreach ($jailimport as $dummykey => $currentRecord) {
            $currentJailImport = new JailImport();
            $currentJailImport->j_source = $currentRecord->source;
            $currentJailImport->j_check_number = $currentRecord->check_no;
            $currentJailImport->j_date_1 = $this->convertDate($currentRecord->date_1);
            $currentJailImport->j_rec_number = $currentRecord->rec_no;
            $currentJailImport->j_date_2 = $this->convertDate($currentRecord->date_2);
            $currentJailImport->j_bat_number = $currentRecord->bat_no;
            $currentJailImport->j_def_last_name = $currentRecord->def_last_name;
            $currentJailImport->j_def_first_name = $currentRecord->def_first_name;
            $currentJailImport->j_def_middle = $currentRecord->def_middle;
            $currentJailImport->j_def_suffix = $currentRecord->def_suffix;
            $currentJailImport->j_def_address = $currentRecord->def_address;
            $currentJailImport->j_def_city = $currentRecord->def_city;
            $currentJailImport->j_def_state = $currentRecord->def_state;
            $currentJailImport->j_def_zip = $currentRecord->def_zip;
            $currentJailImport->j_index_number = $currentRecord->index_no;
            $currentJailImport->j_court_number = $currentRecord->court_no;
            $currentJailImport->j_type = $currentRecord->type;
            $currentJailImport->j_bail_amount = $currentRecord->bail_amt;
            $currentJailImport->j_surety_last_name = $currentRecord->surety_last_name;
            $currentJailImport->j_surety_first_name = $currentRecord->surety_first_name;
            $currentJailImport->j_surety_address = $currentRecord->surety_address;
            $currentJailImport->j_surety_city = $currentRecord->surety_city;
            $currentJailImport->j_surety_state = $currentRecord->surety_state;
            $currentJailImport->j_surety_zip = $currentRecord->surety_zip;
            $currentJailImport->j_surety_phone = $currentRecord->surety_phone;
            $currentJailImport->save();
        }
        echo "done";
    }

    private function convertDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

}