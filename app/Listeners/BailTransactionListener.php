<?php

namespace App\Listeners;

use App\Events\ValidateTransactionBalance;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BailTransactionListener
{
    private $bailMaster;
    private $transactionResults;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(ValidateTransactionBalance $event)
    {
        //
        $this->bailMaster = $event->bailMaster;
        $transactionResults = $this->getTransactionAmount($this->bailMaster->BailTransactions);
        $event->balance = $this->getBalance();
        return $event->balance;
    }

    public function getBalance()
    {
        $moneyOut = $this->transactionResults['transactionFee'] + $this->transactionResults['transactionRefund'];
        $balance = $this->transactionResults['moneyIn'] - $moneyOut;
        return $balance;
    }

    public function validateBalance()
    {
        $moneyOut = $this->transactionResults['transactionFee'] + $this->transactionResults['transactionRefund'];
        $balance = $this->transactionResults['moneyIn'] - $moneyOut;

        if ($balance < 0) {
            return true;
        }
        return false;
    }

    private function getTransactionAmount( $transactionArray)
    {
        $moneyIn = 0;
        $transactionFee = 0;
        $transactionRefund = 0;

        foreach ($transactionArray as $key => $currentTransaction) {
            $moneyIn += $currentTransaction->t_amount;
            $transactionFee += $currentTransaction->t_fee_percentage;
            $transactionRefund += $currentTransaction->t_total_refund;
        }

        $this->transactionResults = [
                                        'moneyIn' => $moneyIn,
                                        'transactionFee' => $transactionFee,
                                        'transactionRefund' => $transactionRefund,
                                     ];
    }

}
