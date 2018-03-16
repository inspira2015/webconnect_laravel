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
}