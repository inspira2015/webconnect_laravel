<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JailImport;
use App\Models\Courts;
use Form;
use View;
use DB;

class EnterBailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexArray = [
                        'message' => 'Sub Menu',
                      ];


        return view('enterBail.index')->with($indexArray);
    }

    /**
     * [jailImport Display Enter Bail by Jail Import]
     * @return [type] [description]
     */
    public function jailImport()
    {
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();

        $indexArray = [
                        'jailRecords' => array(),
                        'totalCheckAmount' => '',
                        'color1' => "#EEEEEE",
                        'color2' => "#CCCCCC",
                        'row_count' => 0,
                        'check_total' => 0,
                        'keyno' => 0,
                        'courtList' => $courtList,
                      ];
        return view('enterBail.jailImport')->with($indexArray);
    }

    /**
     * [searchchecknumber description]
     * @return [type] [description]
     */
    public function searchchecknumber(Request $request)
    {
        $checkNumber = $request->input('check_no');
        $jailImport = new JailImport();
        $jailRecords = $jailImport->GetJailRecordsByCheckNumber($checkNumber);
        $totalJailRecords = $jailImport->GetJailRecordsTotalByCheckNumber();
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();

        $indexArray = [
                        'checkNumber' => $checkNumber,
                        'totalCheckAmount' => $totalJailRecords,
                        'jailRecords' => $jailRecords,
                        'color1' => "#EEEEEE",
                        'color2' => "#CCCCCC",
                        'row_count' => 0,
                        'check_total' => 0,
                        'keyno' => 0,
                        'courtList' => $courtList,
                      ];
        return view('enterBail.jailImport')->with($indexArray);
    }


    public function searchcheckajax(Request $request)
    {
        $query = $request->get('term','');
        $jailImport = new JailImport();
        $jailRecords = $jailImport->GetJailRecordsLikeCheckNumber($query);

        $data = array();

        foreach ($jailRecords as $currentRecord) {
                $data[] = ['value'=> $currentRecord->j_check_number, 'id'=> $currentRecord->j_id];
        }
        
        if (count($data)) {
             return $data;
        } else{
            return ['value'=>'No Result Found','id'=>''];
        }
    
    }


    public function checkolddatabase()
    {
        $jailimport = DB::connection('mysql2')->table('jailimport')->get();

        foreach ($jailimport as $currentRecord) {
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
