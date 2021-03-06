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
use App\Libraries\TransactionDetails;
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
            $userInput        = $request->all();
            $bailMaster       = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = new BailTransactions();
            $balance          = Event::fire(new ValidateTransactionBalance($bailMaster));
            $searchTerm       = "{$bailMaster->m_id} {$bailMaster->m_index_number}";

            if ($balance[0] <= 0) {
               return $this->redirectNoBalance($searchTerm);
            }
            $stdObject = new \stdClass();
            $stdObject->refundType = $userInput['refund_type'];
            $stdObject->bailMaster = $bailMaster;
            $stdObject->balance    = $balance[0];
            $stdObject->fee        = CountyFee::getFeePercentaje();
            $transactionDetails    = $this->createTransactionArray($stdObject);
            $newTransaction        = Event::fire(new RefundTransaction($transactionDetails));
        }
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }

    public function partialrefund(Request $request)
    {
        if ($request->isMethod('post')) {
            $userInput        = $request->all();
            $bailMaster       = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = new BailTransactions();
            $balance          = Event::fire(new ValidateTransactionBalance($bailMaster));
            $searchTerm       = "{$bailMaster->m_id} {$bailMaster->m_index_number}";

            if ($balance[0] <= 0) {
                return $this->redirectNoBalance($searchTerm);
            }
            $stdObject = new \stdClass();
            $stdObject->refundType = 'Partial';
            $stdObject->bailMaster = $bailMaster;
            $stdObject->balance    = $userInput['refund_amount'];
            $stdObject->fee        = CountyFee::getFeePercentaje();

            $transactionDetails = $this->createTransactionArray($stdObject);
            $newTransaction     = Event::fire(new RefundTransaction($transactionDetails));
        }
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }

    public function multicheck(Request $request)
    {
        if ($request->isMethod('post')) {
            $userInput        = $request->all();
            $bailMaster       = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = new BailTransactions();
            $balance          = Event::fire(new ValidateTransactionBalance($bailMaster));
            $searchTerm       = "{$bailMaster->m_id} {$bailMaster->m_index_number}";

            if ($balance[0] <= 0) {
                return $this->redirectNoBalance($searchTerm);
            }
            $stdObject                       = new \stdClass();
            $stdObject->refundType           = 'Multicheck';
            $stdObject->bailMaster           = $bailMaster;
            $stdObject->multiCheckAmount     = $userInput['multicheck_amount'];
            $stdObject->balance              = $balance[0];
            $stdObject->fee                  = CountyFee::getFeePercentaje();
            $stdObject->t_multi_court_number = $userInput['courtcheck_id'];

            $transactionDetails = $this->createTransactionArray($stdObject);
            $newTransaction     = Event::fire(new RefundTransaction($transactionDetails));
        }
        return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }

    public function reversetransaction(Request $request)
    {
         if ($request->isMethod('post')) {
            $userInput        = $request->all();
            $redirectModule   = $userInput['module_name'];
            $bailMaster       = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = BailTransactions::find(array('t_id' => $userInput['t_id']))->first();

            if ($bailTransactions->t_no_reversal != 1) {
                $stdObject                   = new \stdClass();
                $stdObject->refundType       = 'Reversal';
                $stdObject->bailMaster       = $bailMaster;
                $stdObject->bailTransactions = $bailTransactions;

                $transactionDetails = $this->createReversalTransaction($stdObject);
                $newTransaction     = Event::fire(new RefundTransaction($transactionDetails));
            }
        }
        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        session(['search_term' => $searchTerm]);
        return $this->redirectToInputModule($redirectModule);
    }

    private function redirectToInputModule($module)
    {
        $redirectRoute = '';

        if ($module == 'processbail') {
            $redirectRoute = 'processbailresults';
        } elseif($module == 'remission') {
            $redirectRoute = 'remissionsearch';
        }
        return redirect()->route($redirectRoute);
    }

    private function createReversalTransaction($objInfo)
    {
        $transactionInfo                 = new \stdClass();
        $transactionInfo->m_id           = $objInfo->bailMaster->m_id;
        $transactionInfo->t_type         = 'K';
        $transactionInfo->t_amount       = $this->getTransactionAmountForReversal($objInfo->bailTransactions);
        $transactionInfo->t_check_number = 'REVERSAL';
        $transaction                     = new TransactionDetails($transactionInfo);
        $transactionResultArray          = $transaction->getTransactionArray();

        if ($transactionResultArray == false) {
                throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
        }
        $transactionArray['Reversal']    = $transactionResultArray;
        $transactionArray['Reversal_id'] = $objInfo->bailTransactions->t_id;
        return $transactionArray;
    }

    private function redirectNoBalance($searchTerm)
    {
        $messages = [
                                'Insufficient Bail Balance',
                    ];
        return redirect()->route('processbailresults', ['search_term' => $searchTerm])->withErrors($messages);
    }

    private function getTransactionAmountForReversal($transaction)
    {
        $transactionRefund = (float) $transaction->t_total_refund;
        $transactionFee    = (float) $transaction->t_fee_percentage;

        if ($transactionRefund == 0) {
            return $transactionFee;
        }
        return $transactionRefund;
    }

    private function createTransactionArray($objInfo)
    {
        if ($objInfo->refundType == 'full') {
            $transactionInfo                 = new \stdClass();
            $transactionInfo->m_id           = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type         = 'P';
            $transactionInfo->t_total_refund = $objInfo->balance;
            $transaction                     = new TransactionDetails($transactionInfo);
            $transactionResultArray          = $transaction->getTransactionArray();

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
                $transaction                       = new TransactionDetails($transactionInfo);
                $transactionResultArray            = $transaction->getTransactionArray();

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
                $transaction                           = new TransactionDetails($transactionInfo);
                $transactionResultArray                = $transaction->getTransactionArray();

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
                $transaction                           = new TransactionDetails($transactionInfo);
                $transactionResultArray                = $transaction->getTransactionArray();

                if ($transactionResultArray == false) {
                    throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
                }
                $transactionArray['Payment_2'] = $transactionResultArray;
            }

        } else {
            $transactionInfo                   = new \stdClass();
            $transactionInfo->m_id             = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type           = 'C';
            $transactionInfo->t_fee_percentage = CountyFee::getAmountFee($objInfo->balance);
            $transaction                       = new TransactionDetails($transactionInfo);
            $transactionResultArray            = $transaction->getTransactionArray();

            if ($transactionResultArray == false) {
                throw new \Exception('Invalid Transaction Array Type: ' . $objInfo->refundType);
            }
            $transactionArray['Fee'] = $transactionResultArray;

            $transactionInfo         = new \stdClass();
            $transactionInfo->m_id   = $objInfo->bailMaster->m_id;
            $transactionInfo->t_type = 'P';

            if ($objInfo->refundType == 'Partial') {
                $transactionInfo->t_total_refund = $objInfo->balance;
            } else {
                $transactionInfo->t_total_refund = CountyFee::getRemainAmountAfterFee($objInfo->balance);
            }
            $transaction                         = new TransactionDetails($transactionInfo);
            $transactionResultArray              = $transaction->getTransactionArray();
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
                     'courtAmount'  => (float) $multiCheckAmount,
                     'suretyAmount' => 0,
            ];
        }

        $courtAmount  = $multiCheckAmount + $multiCheckFee;
        $suretyAmount = $balance - $courtAmount;
        return [
                     'countyFee'    => (float) $multiCheckFee,
                     'courtAmount'  => (float) $multiCheckAmount,
                     'suretyAmount' => (float) $suretyAmount,

        ];
    }

}