<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Events\ValidateTransactionBalance;
use App\Events\RefundTransaction;

use Event;
use Session;


class BailRefundProcessController extends EnterBailController
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


    public function refundbalance(Request $request)
    {
        if ($request->isMethod('post')) {
            $userInput = $request->all();
            $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = new BailTransactions();
            $balance = Event::fire(new ValidateTransactionBalance($bailMaster));

            if ($balance[0] <= 0) {
                echo "no Balance";
                exit;
            }

            $transactionDetails = [ 'Payment' => 
                                    [
                                        'm_id'                 => $bailMaster->m_id,
                                        't_created_at'         => date('Y-m-d G:i:s'),
                                        't_numis_doc_id'       => 1,
                                        't_debit_credit_index' => 'O',
                                        't_type'               => 'P',
                                        't_amount'             => 0,
                                        't_fee_percentage'     => 0,
                                        't_total_refund'       => $balance[0],
                                        't_reversal_index'     => 0,
                                        't_check_number'       => 'NIFS',
                                        't_mult_check_index'   => 0,
                                    ]
                                  ];

            
            $newTransaction = Event::fire(new RefundTransaction($transactionDetails));
        }

        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }

    public function partialrefund(Request $request)
    {
        $userInput = $request->all();
        $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']));

        dd($userInput);
        exit;
    }
    
    public function multicheck(Request $request)
    {
        $userInput = $request->all();
        $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']));

        dd($userInput);
        exit;
    }
}