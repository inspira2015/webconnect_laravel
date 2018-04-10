<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\BailConfiguration;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use Carbon\Carbon;
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
        $bailMaster = BailMaster::firstOrNew(array('m_id' => 0));
        $dt = new Carbon($bailMaster->m_posted_date);
        $m_posted_date =  $dt->format("m/d/Y");

        $indexArray = [
                        'courtList'      => $courtList,
                        'stateList'      => $stateList,
                        'edit'           => false,
                        't_numis_doc_id' => '',
                        'm_posted_date'  => $m_posted_date,
                      ];

        return view('enterBail.jailImportManualEntry', compact('bailMaster'))->with($indexArray);
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

            if (empty($userInputData['m_id'])) {
                $queryResults = BailMaster::ValidateUniqueRecord([
                                                                   'index_number' => $userInputData['m_index_number'],
                                                                   'index_year'   => $userInputData['m_index_year'],
                                                                 ]);
                if (!empty($queryResults)) {
                    return Redirect::back()->withInput($request->all());
                }
            }

            if (isset($userInputData['m_comments_ind'])) {
                $bailComments = 'Y';
            }

            $bailMasterData = [
                                    "m_id"                => $userInputData['m_id'],
                                    "j_check_number"      => '',
                                    "m_index_number"      => $userInputData['m_index_number'],
                                    "m_index_year"        => $userInputData['m_index_year'],
                                    "m_court_number"      => $userInputData['m_court_number'],
                                    "m_posted_date"       => date("Y-m-d", strtotime($userInputData['m_posted_date'])),
                                    "m_def_last_name"     => $userInputData['m_def_last_name'],
                                    "m_def_first_name"    => $userInputData['m_def_first_name'],
                                    "m_surety_last_name"  => $userInputData['m_surety_last_name'],
                                    "m_surety_first_name" => $userInputData['m_surety_first_name'],
                                    "m_receipt_amount"    => $userInputData['m_receipt_amount'],
                                    "m_comments_ind"      => $bailComments,
                                    "m_status"            => 'O',
                                    "m_surety_address"    => $userInputData['m_surety_address'],
                                    "m_surety_city"       => $userInputData['m_surety_city'],
                                    "m_surety_state"      => $userInputData['m_surety_state'],
                                    "m_surety_zip"        => $userInputData['m_surety_zip'],
                                    "m_forfeit_amount"    => 0,
                                    "m_payment_amount"    => 0,
                                    "m_city_fee_amount"   => 0,
                                  ];
            $bailMasterId = $this->addBailMasterRecord($bailMasterData);

            $bailTransactionData = [
                                    "t_type"               => 'R',
                                    "t_numis_doc_id"       => $userInputData['t_numis_doc_id'],
                                    "t_created_at"         => date("Y-m-d", strtotime($userInputData['m_posted_date'])),
                                    "t_debit_credit_index" => 'I',
                                    "t_amount"             => $userInputData['m_receipt_amount'],
                                    "t_fee_percentage"     => 0,
                                    "t_total_refund"       => 0,
                                    "t_reversal_index"     => '',
                                   ];
            $this->addTransactionRecord($bailTransactionData, $bailMasterId);

        }
        $bailMaster = BailMaster::find($bailMasterId);
        $transaction = $bailMaster->BailTransactions->where('t_type', '=', 'R')->first();
        return view('enterBail.processmanualentry', compact('bailMaster'))->with(['transaction' => $transaction]);
    }

    public function editManualRecord(Request $request)
    {
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $manualEntry = $request->all();
        $bailMaster = BailMaster::firstOrNew(array('m_id' => (int) $manualEntry['master_id']));
        $transaction = $bailMaster->BailTransactions->where('t_type', '=', 'R')->first();

        $dt = new Carbon($bailMaster->m_posted_date);
        $m_posted_date =  $dt->format("m/d/Y");

        if (empty($queryResults)) {

        }
        $indexArray = [
                        'courtList'      => $courtList,
                        'stateList'      => $stateList,
                        'edit'           => true,
                        't_numis_doc_id' => $transaction->t_numis_doc_id,
                        'm_posted_date'  => $m_posted_date,
                      ];
        return view('enterBail.jailImportManualEntry', compact('bailMaster'))->with($indexArray);
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
