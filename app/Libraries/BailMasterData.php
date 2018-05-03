<?php

namespace App\Libraries;
use App\Models\BailTransactions;
use App\Models\BailForfeitures;
use App\Facades\CountyFee;
use Carbon\Carbon;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Models\BailComments;
use App\Events\ValidateTransactionBalance;
use App\Libraries\TransactionValidations;
use App\Libraries\Services\BuildCorrectState;
use Event;
use Session;

class BailMasterData
{

	public function createViewArray($bailMasterId, $module, BuildCorrectState $stateValidate)
	{
		$bailMasterId          = (int) $bailMasterId;
        $transactionValidation = new TransactionValidations($module);
		$bailMaster            = BailMaster::find($bailMasterId);
        $courtList             = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList             = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $courtCheckList        = BailConfiguration::where('bc_category', 'check_court')->pluck('bc_value', 'bc_id')->toArray();
        $bailMaterComments     = BailComments::GetBailMasterComments($bailMasterId);
        $dt                    = new Carbon($bailMaster->m_posted_date);
		$m_posted_date         = $dt->format("m/d/Y");
        $stateConfiguration    = $stateValidate->getStateArray($bailMaster->m_surety_state);
        $resultBalance         = Event::fire(new ValidateTransactionBalance($bailMaster));
        $balance               = round($resultBalance[0], 2);

        return [
        		 'bailMaster'            => $bailMaster,
                 'transactionValidation' => $transactionValidation,
        		 'bailMaterComments'     => $bailMaterComments,
                 'jailRecords'           => array(),
                 'bailMasterId'          => $bailMasterId,
                 'balance'               => $balance,
                 'stateList'             => $stateList,
                 'courtList'             => $courtList,
                 'courtCheckList'        => $courtCheckList,
                 'm_posted_date'         => $m_posted_date,
                 'module'                => $module,
                 'stConfig'              => $stateConfiguration,
                 'bailDetails'           => [
                                             'total_balance'  => $balance,
                                             'fee_percentaje' => CountyFee::getFeePercentaje(),
                                             'fee_amount'     => CountyFee::getAmountFee($balance),
                                             'remain_amount'  => CountyFee::getRemainAmountAfterFee($balance),
                                            ],
               ];
	}
}