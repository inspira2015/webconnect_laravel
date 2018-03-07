<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\BailConfiguration;
use App\Models\Courts;
use App\Models\BailMaster;

use Redirect;
use Auth;


class EnterBailManualController extends EnterBailController
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
     * [manualentry Manual Entry form]
     * @return [type] [description]
     */
    public function index()
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

            if (isset($userInputData['defendant_comments'])) {
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



}
