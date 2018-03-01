<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Models\BailConfiguration;


use Auth;
use Input;
use Form;
use Session;
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
                        'processBail' => true,
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
        $jailIdArray = $jailImport->GetAllJailIds();
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        Session::put('JailIdArray', $jailIdArray);
        Session::put('checkNumber', $checkNumber);
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
                        'processBail' => true,
                      ];
        return view('enterBail.jailImport')->with($indexArray);
    }


    /**
     * [processbails Process Bails]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function processbails(Request $request)
    {

        if ($request->isMethod('post')) {
            $jailIdArray = Session::get('JailIdArray');
            $userInputData = $request->all();
            $processDate = date('Y-m-d G:i:s');
            $checkNumber = Session::get('checkNumber');
            
            foreach ($jailIdArray AS $key => $value) {
                $jailImportRecord = JailImport::GetJailRecordSplitById($value);
                $bailAmount = $jailImportRecord->j_bail_amount /100;
                $comment = 'N';

                if ($jailImportRecord->j_def_suffix == "*") {
                    $comment = 'Y';
                }

                $bailMaster = BailMaster::firstOrNew([
                                                       "j_check_number" => $jailImportRecord->j_check_number,
                                                       "m_index_number" => $jailImportRecord->index_number,
                                                       "m_index_year" => $jailImportRecord->index_year,
                                                     ]);
                $courtNumberValues = [
                                      'defualtValue' => (int) $jailImportRecord->j_court_number,
                                      'globalValue' =>  (int) $userInputData['court_number'],
                                      'rowValue' =>     (int) $userInputData['court_no'][$value],
                                     ];

                $bailMaster->m_court_number = $this->getCorrectCourtNumber($courtNumberValues);
                $bailMaster->m_index_number = $userInputData['index_no'][$value];
                $bailMaster->m_index_year = $userInputData['index_year'][$value];
                $bailMaster->m_posted_date = date("Y-m-d", strtotime($userInputData['daterec'][$value]));
                $bailMaster->m_def_last_name = $jailImportRecord->j_def_last_name;
                $bailMaster->m_def_first_name = $jailImportRecord->j_def_first_name;
                $bailMaster->m_surety_last_name = $jailImportRecord->j_surety_last_name;
                $bailMaster->m_surety_first_name = $jailImportRecord->j_surety_first_name;
                $bailMaster->m_forfeit_amount = 0;
                $bailMaster->m_payment_amount = 0;
                $bailMaster->m_city_fee_amount = 0;
                $bailMaster->m_receipt_amount = $bailAmount;
                $bailMaster->m_comments_ind =  $comment;
                $bailMaster->m_status = 'O';
                $bailMaster->m_surety_address = $jailImportRecord->j_surety_address;
                $bailMaster->m_surety_city = $jailImportRecord->j_surety_city;
                $bailMaster->m_surety_state = $jailImportRecord->j_surety_state;
                $bailMaster->m_surety_zip = $jailImportRecord->j_surety_zip;
                $bailMaster->save();

                $bailTransaction = BailTransactions::firstOrNew([
                                                                  "m_id" => $bailMaster->m_id,
                                                                  "t_type" => 'R'
                                                                ]);

                $bailTransaction->m_id = $bailMaster->m_id;
                $bailTransaction->t_numis_doc_id = $userInputData['docno'];
                $bailTransaction->t_created_at = $processDate;
                $bailTransaction->t_debit_credit_index = 'I';
                $bailTransaction->t_type = 'R';
                $bailTransaction->t_amount = $bailAmount;
                $bailTransaction->t_fee_percentage = 0;
                $bailTransaction->t_total_refund = 0;
                $bailTransaction->t_reversal_index = '';
                $bailTransaction->save();
            }

            $checkNumber = Session::get('checkNumber');
            $jailImport = new JailImport();
            $jailRecords = $jailImport->GetJailRecordsByCheckNumber($checkNumber);

            $totalJailRecords = $jailImport->GetJailRecordsTotalByCheckNumber();
            $jailIdArray = $jailImport->GetAllJailIds();
            $courtList = Courts::pluck('c_name', 'c_id')->toArray();
            Session::put('JailIdArray', $jailIdArray);
            Session::put('checkNumber', $checkNumber);
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
                            'processBail' => false,
                          ];
        return view('enterBail.jailImport')->with($indexArray);
        }
    }

    public function searchcheckajax(Request $request)
    {
        $query = $request->get('term','');
        $jailImport = new JailImport();
        $jailRecords = $jailImport->GetCheckNumbersLikeInput($query);

        $data = array();

        foreach ($jailRecords as $dummykey => $currentRecord) {
                $data[] = ['value'=> $currentRecord->j_check_number, 'id'=> $currentRecord->j_id];
        }
        
        if (count($data)) {
             return $data;
        } else{
            return ['value'=>'No Result Found','id'=>''];
        }    
    }

    /**
     * [manualentry Manual Entry form]
     * @return [type] [description]
     */
    public function manualentry()
    {
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();

        $indexArray = [
                        'courtList' => $courtList,
                        'stateList' => $stateList,
                      ];
        return view('enterBail.jailImportManualEntry')->with($indexArray);
    }

    /**
     * [processmanualentry description]
     * @return [type] [description]
     */
    public function processmanualentry(Request $request)
    {
        echo "done";
        exit;
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

    private function getCorrectCourtNumber($courtValues)
    {   
        if ($courtValues['defualtValue'] !== $courtValues['globalValue']) {

            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {
                //echo "1";
                //echo $courtValues['globalValue'];
                //exit;
                return $courtValues['globalValue'];
            } else {
                //echo "2";
                //exit;
                return $courtValues['rowValue'];
            }
        } else {
            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {
                //echo "3";
                //exit;
                return $courtValues['defualtValue'];
            } else {
                //echo "4";
                //exit;
                return $courtValues['rowValue'];
            }
        }

    }
}
