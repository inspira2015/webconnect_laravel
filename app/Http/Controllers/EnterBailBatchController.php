<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\JailImport;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Facades\CheckNumberRecords;
use App\Events\ImportJailRecord;
use App\Facades\CreateTransaction;
use Event;
use Session;


class EnterBailBatchController extends EnterBailController
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
     * [jailImport Display Enter Bail by Jail Import]
     * @return [type] [description]
     */
    public function index()
    {
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        $indexArray = [
                        'jailRecords' => array(),
                        'totalCheckAmount' => '',
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
                if (!isset($userInputData['selected'][$value])) {
                    continue;
                }
                $validMaster = Event::fire(new ImportJailRecord($userInputData, $value));

                $jailImportRecord = JailImport::GetJailRecordSplitById($value);
                $bailAmount = $jailImportRecord->j_bail_amount /100;
                $comment = 'N';

                if ($jailImportRecord->j_def_suffix == "*") {
                    $comment = 'Y';
                }

                $courtNumberValues = [
                                       "defualtValue"     => (int) $jailImportRecord->j_court_number,
                                       "globalValue"      => (int) $userInputData['court_number'],
                                       "rowValue"         => (int) $userInputData['court_no'][$value],
                                     ];
                $bailMasterData = [
                                    "m_id"                => $validMaster[0]->m_id,
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
                CreateTransaction::add($bailTransactionData, $bailMasterId);
            }

            $checkNumber = Session::get('checkNumber');
            $jailImport = new JailImport();
            $jailRecords = $jailImport->GetJailRecordsByCheckNumber($checkNumber);

            $totalJailRecords = $jailImport->GetJailRecordsTotalByCheckNumber($checkNumber);
            $jailIdArray = $jailImport->GetAllJailIds();
            $courtList = Courts::pluck('c_name', 'c_id')->toArray();
            Session::put('JailIdArray', $jailIdArray);
            Session::put('checkNumber', $checkNumber);
            $indexArray = [
                            'checkNumber' => $checkNumber,
                            'totalCheckAmount' => $totalJailRecords,
                            'jailRecords' => $jailRecords,
                            'courtList' => $courtList,
                            'processBail' => CheckNumberRecords::validateRecordsBetweenJailAndMaster($checkNumber),
                          ];
        return view('enterBail.jailImport')->with($indexArray);
        }
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

        if (empty($checkNumber) || empty($jailRecords)) {
            $messages = [
                            "\"{checkNumber}\" was not found",
                        ];
            return redirect()->route('jailcheck')->withErrors($messages);
        }
        $totalJailRecords = $jailImport->GetJailRecordsTotalByCheckNumber($checkNumber);
        $jailIdArray = $jailImport->GetAllJailIds();
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        Session::put('JailIdArray', $jailIdArray);
        Session::put('checkNumber', $checkNumber);
        $indexArray = [
                        'checkNumber' => $checkNumber,
                        'totalCheckAmount' => $totalJailRecords,
                        'jailRecords' => $jailRecords,
                        'courtList' => $courtList,
                        'processBail' => CheckNumberRecords::validateRecordsBetweenJailAndMaster($checkNumber),
                      ];
        return view('enterBail.jailImport')->with($indexArray);
    }
}