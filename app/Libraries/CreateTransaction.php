<?php

namespace App\Libraries;
use App\Models\BailTransactions;

class CreateTransaction
{

    public function add(array $bailTransactionData, $bailMasterId = false)
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
}