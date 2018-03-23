<?php

namespace App\Libraries;
use App\Models\BailConfiguration;

class CountyFee
{

    public function getFeePercentaje($data = [])
    {
        $feeRow = BailConfiguration::GetFeePercentaje();
        return $feeRow[0]->bc_value / 100;
    }

    public function getAmountFee($amountToBeCalculated)
    {
    	return $amountToBeCalculated * $this->getFeePercentaje();
    }

    public function getRemainAmountAfterFee($amountToBeCalculated)
    {
    	return $amountToBeCalculated * (1 - $this->getFeePercentaje());
    }
}