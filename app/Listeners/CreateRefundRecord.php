<?php

namespace App\Listeners;

use App\Events\RefundTransaction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\BailTransactions;
use App\Events\ValidateTransactionBalance;
use DB;

class CreateRefundRecord
{
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
     * @param  RefundTransaction  $event
     * @return void
     */
    public function handle(RefundTransaction $event)
    {
        $transactionDetails = $event->transactionDetails;
        DB::beginTransaction();
        $event->transactionError = false;

        foreach ($transactionDetails as $key => $currentTransaction) {
            if ($key == 'Reversal_id') {
                $transaction = BailTransactions::find(array('t_id' => $currentTransaction))->first();
                $transaction->t_no_reversal = 1;
                $transaction->save();
            } else {
                $transaction = new BailTransactions();
                $transaction->m_id                 = $currentTransaction['m_id'];
                $transaction->t_created_at         = $currentTransaction['t_created_at'];
                $transaction->t_numis_doc_id       = $currentTransaction['t_numis_doc_id'];
                $transaction->t_debit_credit_index = $currentTransaction['t_debit_credit_index'];
                $transaction->t_type               = $currentTransaction['t_type'];
                $transaction->t_amount             = $currentTransaction['t_amount'];
                $transaction->t_fee_percentage     = $currentTransaction['t_fee_percentage'];
                $transaction->t_total_refund       = $currentTransaction['t_total_refund'];
                $transaction->t_reversal_index     = $currentTransaction['t_reversal_index'];
                $transaction->t_check_number       = $currentTransaction['t_check_number'];
                $transaction->t_mult_check_index   = $currentTransaction['t_mult_check_index'];
                $transaction->save();
            }

            if (!$transaction) {
                $event->transactionError = true;
                DB::rollback();
            }
            unset($transaction);
        }
        DB::commit();
        return $event->transactionError;
    }
}
