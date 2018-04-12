<?php

namespace App\Libraries;
use App\Models\BailTransactions;
use App\Models\BailForfeitures;
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

        $bailTransactionData['m_id'] = $bailMasterId;

        foreach ($bailTransactionData as $key => $value) {
            $bailTransaction->$key = $value;
        }
        $bailTransaction->save();
        return $bailTransaction->t_id;
    }

    public function AddForfeiture($formDetails, $forfeitureId)
    {
        $todayDate = date('Y-m-d');
        $amount = $formDetails['amount'];
        if ($amount <= 0) {
            return false;
        }
        $t_check_number = $formDetails['t_check_number'];
        $bailForfeiture = BailForfeitures::find($forfeitureId);
        $bailMasterId = $bailForfeiture->m_id;

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
                                "t_check_number"       => $t_check_number,
                               ];
        if (!$this->add($bailTransactionData, $bailMasterId)) {
            DB::rollback();
            return false;
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
                                "t_check_number"       => $t_check_number,
                               ];
        if (!$this->add($bailTransactionData, $bailMasterId)) {
            DB::rollback();
            return false;
        }

        // Update Forfeiture Record mark it as processed
        $bailForfeiture->bf_processed = 1;
        $bailForfeiture->save();
        DB::commit();
        unset($bailForfeiture);
        return true;
    }
}