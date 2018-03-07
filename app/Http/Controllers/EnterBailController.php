<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Models\BailConfiguration;

use Redirect;
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

                $courtNumberValues = [
                                      'defualtValue' => (int) $jailImportRecord->j_court_number,
                                      'globalValue'  => (int) $userInputData['court_number'],
                                      'rowValue'     => (int) $userInputData['court_no'][$value],
                                     ];
                $bailMasterData = [
                                    "j_check_number"      => $jailImportRecord->j_check_number,
                                    "m_index_number"      => $jailImportRecord->index_number,
                                    "m_index_year"        => $jailImportRecord->index_year,
                                    "m_court_number"      => $this->getCorrectCourtNumber($courtNumberValues),
                                    "m_posted_date"       => date("Y-m-d", strtotime($userInputData['daterec'][$value])),
                                    "m_def_last_name"     => $jailImportRecord->j_def_last_name,
                                    "m_def_first_name"    => $jailImportRecord->j_def_first_name,
                                    "m_surety_last_name"  => $jailImportRecord->j_surety_last_name,
                                    "m_surety_first_name" => $jailImportRecord->j_surety_first_name,
                                    "m_receipt_amount"    => $bailAmount,
                                    "m_comments_ind"      => $comment,
                                    "m_status"            => 'O',
                                    "m_surety_address"    => $jailImportRecord->j_surety_address,
                                    "m_surety_city"       => $jailImportRecord->j_surety_city,
                                    "m_surety_state"      => $jailImportRecord->j_surety_state,
                                    "m_surety_zip"        => $jailImportRecord->j_surety_zip,
                                    "m_forfeit_amount"    => 0,
                                    "m_payment_amount"    => 0,
                                    "m_city_fee_amount"   => 0,
                                  ];
                $bailMasterId = $this->addBailMasterRecord($bailMasterData);

                $bailTransactionData = [
                                         "t_type"               => 'R',
                                         "t_numis_doc_id"       => $userInputData['docno'],
                                         "t_created_at"         => $processDate,
                                         "t_debit_credit_index" => 'I',
                                         "t_amount"             => $bailAmount,
                                         "t_fee_percentage"     => 0,
                                         "t_total_refund"       => 0,
                                         "t_reversal_index"     => '',
                                       ];

                $this->addTransactionRecord($bailTransactionData, $bailMasterId);
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
        if ($request->isMethod('post')) {
            $bailComments = 'N';
            $userInputData = $request->all();
            $indexNumber = $userInputData['index_number'];
            $indexYear = $userInputData['index_year'];
            $queryResults = BailMaster::ValidateUniqueRecord([
                                                               'index_number' => $indexNumber,
                                                               'index_year'   => $indexYear
                                                             ]);
            if (!empty($queryResults)) {
                return Redirect::back()->withInput($request->all());
            }

            if ($userInputData['defendant_comments']) {
                $bailComments = 'Y';
            }
            
            $bailMasterData = [
                                    "j_check_number"      => '',
                                    "m_index_number"      => $userInputData['index_number'],
                                    "m_index_year"        => $userInputData['index_year'],
                                    "m_court_number"      => $userInputData['court_number'],
                                    "m_posted_date"       => date("Y-m-d", strtotime($userInputData['posted_date'])),
                                    "m_def_last_name"     => $userInputData['defendant_last_name'],
                                    "m_def_first_name"    => $userInputData['defendant_first_name'],
                                    "m_surety_last_name"  => $userInputData['surety_last_name'],
                                    "m_surety_first_name" => $userInputData['surety_first_name'],
                                    "m_receipt_amount"    => $userInputData['bail_amount'],
                                    "m_comments_ind"      => $bailComments,
                                    "m_status"            => 'O',
                                    "m_surety_address"    => $userInputData['surety_address'],
                                    "m_surety_city"       => $userInputData['surety_city'],
                                    "m_surety_state"      => $userInputData['surety_state'],
                                    "m_surety_zip"        => $userInputData['surety_zip'],
                                    "m_forfeit_amount"    => 0,
                                    "m_payment_amount"    => 0,
                                    "m_city_fee_amount"   => 0,
                                  ];
            $bailMasterId = $this->addBailMasterRecord($bailMasterData);

            $bailTransactionData = [
                                    "t_type"               => 'R',
                                    "t_numis_doc_id"       => $userInputData['validation_number'],
                                    "t_created_at"         => date("Y-m-d", strtotime($userInputData['posted_date'])),
                                    "t_debit_credit_index" => 'I',
                                    "t_amount"             => $userInputData['bail_amount'],
                                    "t_fee_percentage"     => 0,
                                    "t_total_refund"       => 0,
                                    "t_reversal_index"     => '',
                                   ];
            $this->addTransactionRecord($bailTransactionData, $bailMasterId);
        }
         return view('enterBail.processmanualentry')->with(array());
    }


    public function validateindexyear(Request $request)
    {
        $userInputData = $request->all();
        $indexNumber = $userInputData['number'];
        $indexYear = $userInputData['year'];

        $queryResults = BailMaster::ValidateUniqueRecord([
                                                            'index_number' => $indexNumber,
                                                            'index_year'   => $indexYear,
                                                         ]);
        if (empty($queryResults)) {
            return response()->json(['result' => 'empty'], 200);
        }

        $bailMasterRow = $queryResults[0];
        return response()->json(['result' => 'duplicate',
                                 'record' =>  $bailMasterRow]);
    }


    public function validateindexyear2(Request $request)
    {
        $userInputData = $request->all();
        $indexNumber = $userInputData['number'];
        $indexYear = $userInputData['year'];

        $queryResults = BailMaster::ValidateUniqueRecord([
                                                            'index_number' => $indexNumber,
                                                            'index_year' => $indexYear,
                                                         ]);
        if (empty($queryResults)) {
            return response()->json('true', 200);
        }
        
        $bailMasterRow = $queryResults[0];
        return response()->json('false');
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

    private function addBailMasterRecord(array $bailMasterData)
    {
        $bailMaster = BailMaster::firstOrNew([
                                                "j_check_number" => $bailMasterData['j_check_number'],
                                                "m_index_number" => $bailMasterData['m_index_number'],
                                                "m_index_year"   => $bailMasterData['m_index_year'],
                                             ]);

        $bailMaster->m_court_number = $bailMasterData['m_court_number'];
        $bailMaster->m_index_number = $bailMasterData['m_index_number'];
        $bailMaster->m_index_year = $bailMasterData['m_index_year'];
        $bailMaster->m_posted_date = $bailMasterData['m_posted_date'];
        $bailMaster->m_def_last_name = $bailMasterData['m_def_last_name'];
        $bailMaster->m_def_first_name = $bailMasterData['m_def_first_name'];
        $bailMaster->m_surety_last_name = $bailMasterData['m_surety_last_name'];
        $bailMaster->m_surety_first_name = $bailMasterData['m_surety_first_name'];
        $bailMaster->m_forfeit_amount = $bailMasterData['m_forfeit_amount'];
        $bailMaster->m_payment_amount = $bailMasterData['m_payment_amount'];
        $bailMaster->m_city_fee_amount = $bailMasterData['m_city_fee_amount'];
        $bailMaster->m_receipt_amount = $bailMasterData['m_receipt_amount'];
        $bailMaster->m_comments_ind =  $bailMasterData['m_comments_ind'];
        $bailMaster->m_status = $bailMasterData['m_status'];
        $bailMaster->m_surety_address = $bailMasterData['m_surety_address'];
        $bailMaster->m_surety_city = $bailMasterData['m_surety_city'];
        $bailMaster->m_surety_state = $bailMasterData['m_surety_state'];
        $bailMaster->m_surety_zip = $bailMasterData['m_surety_zip'];
        $bailMaster->save();
        return $bailMaster->id;
    }

    private function addTransactionRecord(array $bailTransactionData, $bailMasterId = false)
    {
        if (!$bailMasterId) {
            return false;
        }

        $bailTransaction = BailTransactions::firstOrNew([
                                                          "m_id"   => $bailMasterId,
                                                          "t_type" => $bailTransactionData['t_type'],
                                                        ]);

        $bailTransaction->m_id = $bailMasterId;
        $bailTransaction->t_numis_doc_id = $bailTransactionData['t_numis_doc_id'];
        $bailTransaction->t_created_at = $bailTransactionData['t_created_at'];
        $bailTransaction->t_debit_credit_index = $bailTransactionData['t_debit_credit_index'];
        $bailTransaction->t_type = $bailTransactionData['t_type'];
        $bailTransaction->t_amount = $bailTransactionData['t_amount'];
        $bailTransaction->t_fee_percentage = $bailTransactionData['t_fee_percentage'];
        $bailTransaction->t_total_refund =  $bailTransactionData['t_total_refund'];
        $bailTransaction->t_reversal_index =  $bailTransactionData['t_reversal_index'];'';
        $bailTransaction->save();
        return $bailTransaction->t_id;
    }


    private function convertDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    private function getCorrectCourtNumber($courtValues)
    {   
        if ($courtValues['defualtValue'] !== $courtValues['globalValue']) {

            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {
                return $courtValues['globalValue'];
            } else {
                return $courtValues['rowValue'];
            }
        } else {
            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {

                return $courtValues['defualtValue'];
            } else {
                return $courtValues['rowValue'];
            }
        }

    }
}
