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
use App\Facades\CountyFee;

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
            $stdObject = new \stdClass();
            $stdObject->refundType = $userInput['refund_type'];
            $stdObject->bailMaster = $bailMaster;
            $stdObject->balance    = $balance[0];
            $stdObject->fee        = CountyFee::getFeePercentaje();

            $transactionDetails = $this->createTransactionArray($stdObject);
            $newTransaction = Event::fire(new RefundTransaction($transactionDetails));
        }

        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }

    public function partialrefund(Request $request)
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

            $stdObject = new \stdClass();
            $stdObject->refundType = 'Partial';
            $stdObject->bailMaster = $bailMaster;
            $stdObject->balance    = $userInput['refund_amount'];
            $stdObject->fee        = CountyFee::getFeePercentaje();

            $transactionDetails = $this->createTransactionArray($stdObject);
            $newTransaction = Event::fire(new RefundTransaction($transactionDetails));
        }
        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }
    
    public function multicheck(Request $request)
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

            $stdObject = new \stdClass();
            $stdObject->refundType           = 'Multicheck';
            $stdObject->bailMaster           = $bailMaster;
            $stdObject->multiCheckAmount     = $userInput['multicheck_amount'];
            $stdObject->balance              = $balance[0];
            $stdObject->fee                  = CountyFee::getFeePercentaje();
            $stdObject->t_multi_court_number = $userInput['courtcheck_id'];


            $transactionDetails = $this->createTransactionArray($stdObject);
            $newTransaction = Event::fire(new RefundTransaction($transactionDetails));
        }
        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
        dd($userInput);
        exit;
    }

    private function createTransactionArray($objInfo)
    {
        if ($objInfo->refundType == 'full') {
            $transactionInfo = new \stdClass();
            $transactionInfo->m_id = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type = 'P';
            $transactionInfo->t_total_refund = $objInfo->balance;
            $transactionResultArray = $this->getTransactionArray($transactionInfo);
            
            if ($transactionResultArray == false) {
                throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
            }
            $transactionArray['Payment'] = $transactionResultArray;

        } elseif ($objInfo->refundType == 'Multicheck') {
            $multiCheckTransaction = $this->calculateMulticheckPayments($objInfo->balance, $objInfo->multiCheckAmount);

            if ($multiCheckTransaction['countyFee'] > 0) {
                $transactionInfo                   = new \stdClass();
                $transactionInfo->m_id             = $objInfo->bailMaster->m_id;
                $transactionInfo->t_type           = 'C';
                $transactionInfo->t_fee_percentage = $multiCheckTransaction['countyFee'];
                $transactionResultArray            = $this->getTransactionArray($transactionInfo);

                if ($transactionResultArray == false) {
                    throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
                }
                $transactionArray['Fee'] = $transactionResultArray;
            }

            if ($multiCheckTransaction['courtAmount'] > 0) {
                $transactionInfo                       = new \stdClass();
                $transactionInfo->m_id                 = $objInfo->bailMaster->m_id;
                $transactionInfo->t_type               = 'PM';
                $transactionInfo->t_total_refund       = $multiCheckTransaction['courtAmount'];
                $transactionInfo->t_multi_court_number = $objInfo->t_multi_court_number;

                $transactionResultArray = $this->getTransactionArray($transactionInfo);

                if ($transactionResultArray == false) {
                    throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
                }
                $transactionArray['Payment'] = $transactionResultArray;
            }


            if ($multiCheckTransaction['suretyAmount'] > 0) {
                $transactionInfo                       = new \stdClass();
                $transactionInfo->m_id                 = $objInfo->bailMaster->m_id;
                $transactionInfo->t_type               = 'PS';
                $transactionInfo->t_total_refund       = $multiCheckTransaction['suretyAmount'];
                $transactionInfo->t_multi_court_number = $objInfo->t_multi_court_number;

                $transactionResultArray = $this->getTransactionArray($transactionInfo);

                if ($transactionResultArray == false) {
                    throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
                }
                $transactionArray['Payment_2'] = $transactionResultArray;
            }

        } else {
            $transactionInfo = new \stdClass();
            $transactionInfo->m_id = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type = 'C';
            $transactionInfo->t_fee_percentage = CountyFee::getAmountFee($objInfo->balance);
            $transactionResultArray = $this->getTransactionArray($transactionInfo);

            if ($transactionResultArray == false) {
                throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
            }
            $transactionArray['Fee'] = $transactionResultArray;

            $transactionInfo = new \stdClass();
            $transactionInfo->m_id = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type = 'P';

            if ($objInfo->refundType == 'Partial') {
                $transactionInfo->t_total_refund = $objInfo->balance;
            } else {
                $transactionInfo->t_total_refund = CountyFee::getRemainAmountAfterFee($objInfo->balance);
            }
            $transactionResultArray = $this->getTransactionArray($transactionInfo);

            if ($transactionResultArray == false) {
                throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
            }
            $transactionArray['Payment'] = $transactionResultArray;
        }
        return $transactionArray;
    }

    private function calculateMulticheckPayments($balance, $multiCheckAmount)
    {
        $multiCheckFee = CountyFee::getAmountFee($multiCheckAmount);

        if ($balance == $multiCheckAmount) {
            return [
                     'countyFee'    => (float) $multiCheckFee,
                     'courtAmount'  => (float) ($balance - $multiCheckFee),
                     'suretyAmount' => 0,
            ];
        }

        $courtAmount  = $multiCheckAmount + $multiCheckFee;
        $suretyAmount = $balance - $courtAmount;
        return [
                     'countyFee'    => (float) $multiCheckFee,
                     'courtAmount'  => (float) $courtAmount,
                     'suretyAmount' => (float) $suretyAmount,

        ];
    }

    private function getTransactionArray($objInfo)
    {
        $t_debit_credit_index = 'O';
        $t_numis_doc_id = 1;
        $t_fee_percentage = 0;
        $t_total_refund = 0;
        $t_amount = 0;
        $t_reversal_index = 0;
        $t_check_number = 'NIFS';
        $t_mult_check_index = 0;
        $t_created_at = date('Y-m-d G:i:s');

       if (isset($objInfo->m_id)) {
            $m_id = $objInfo->m_id;
        } else {
            return false;
        }


        if (isset($objInfo->t_numis_doc_id)) {
            $t_numis_doc_id = $objInfo->t_numis_doc_id;
        }

        if (isset($objInfo->t_debit_credit_index)) {
            $t_debit_credit_index = $objInfo->t_debit_credit_index;
        }

        if (isset($objInfo->t_type)) {
            $t_type = $objInfo->t_type;
        }

        if (isset($objInfo->t_amount)) {
            $t_amount = $objInfo->t_amount;
        }

        if (isset($objInfo->t_fee_percentage)) {
            $t_fee_percentage = $objInfo->t_fee_percentage;
        }

        if (isset($objInfo->t_total_refund)) {
            $t_total_refund = $objInfo->t_total_refund;
        }

        if (isset($objInfo->t_reversal_index)) {
            $t_reversal_index = $objInfo->t_reversal_index;
        }

        if (isset($objInfo->t_check_number)) {
            $t_check_number = $objInfo->t_check_number;
        }

        if (isset($objInfo->t_mult_check_index)) {
            $t_mult_check_index = $objInfo->t_mult_check_index;
        }

        return [
                 'm_id'                 => $m_id,
                 't_created_at'         => $t_created_at,
                 't_numis_doc_id'       => $t_numis_doc_id,
                 't_debit_credit_index' => $t_debit_credit_index,
                 't_type'               => $t_type,
                 't_amount'             => $t_amount,
                 't_fee_percentage'     => $t_fee_percentage,
                 't_total_refund'       => $t_total_refund,
                 't_reversal_index'     => $t_reversal_index,
                 't_check_number'       => $t_check_number,
                 't_mult_check_index'   => $t_mult_check_index,

        ];
    }

}

      