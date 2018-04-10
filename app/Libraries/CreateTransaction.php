<?php

namespace App\Libraries;
use App\Models\BailTransactions;
use App\Facades\CountyFee;
use DB;

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

    public function AddForfeiture($amount, $bailMasterId)
    {
        $todayDate = date('Y-m-d');
        DB::beginTransaction();
        $feePercentaje = CountyFee::getAmountFee($amount);
        $bailTransactionData = [
                                "t_type"               => 'A',
                                "t_numis_doc_id"       => 1,
                                "t_created_at"         => $todayDate,
                                "t_debit_credit_index" => 'O',
                                "t_amount"             => 0,
                                "t_fee_percentage"     => $feePercentaje,
                                "t_total_refund"       => 0,
                                "t_reversal_index"     => '',
                               ];
        if (!$this->add($bailTransactionData, $bailMasterId)) {
            DB::rollback();
        }

        $amountAfterFee = CountyFee::getRemainAmountAfterFee($amount);
        $bailTransactionData = [
                                "t_type"               => 'F',
                                "t_numis_doc_id"       => 1,
                                "t_created_at"         => $todayDate,
                                "t_debit_credit_index" => 'O',
                                "t_amount"             => 0,
                                "t_fee_percentage"     => 0,
                                "t_total_refund"       => $amountAfterFee,
                                "t_reversal_index"     => '',
                               ];
        if (!$this->add($bailTransactionData, $bailMasterId)) {
            DB::rollback();
        }
        DB::commit();
    }
}