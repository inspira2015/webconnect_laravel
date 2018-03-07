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
        }
        return ['value'=>'No Result Found','id'=>''];    
    }

    protected function addBailMasterRecord(array $bailMasterData)
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

    protected function addTransactionRecord(array $bailTransactionData, $bailMasterId = false)
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


    protected function convertDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    protected function getCorrectCourtNumber($courtValues)
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
