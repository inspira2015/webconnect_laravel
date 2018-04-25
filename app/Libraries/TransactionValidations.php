<?php

namespace App\Libraries;
use Illuminate\Http\Request;
use Session;


class TransactionValidations
{
	public $module;
    public $transaction;

    public function __construct($module = false)
    {
        $this->setModule($module);
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    public function setTransactionModel($transactionObject)
    {
        $this->transaction = $transactionObject;
        return $this;
    }

    public function getAmount()
    {
        if ($this->transaction->t_type == 'R') {
            return $this->transaction->t_amount;
        } elseif ($this->transaction->t_type == 'P') {
            return $this->transaction->t_total_refund;
        } elseif ($this->transaction->t_type == 'C') {
            return $this->transaction->t_fee_percentage;
        } elseif ($this->transaction->t_type == 'PM') {
            return $this->transaction->t_total_refund;
        } elseif ($this->transaction->t_type == 'PS') {
            return $this->transaction->t_total_refund;
        } elseif ($this->transaction->t_type == 'K') {
            return $this->transaction->t_amount;
        } elseif ($this->transaction->t_type == 'A') {
            return $this->transaction->t_fee_percentage;
        } elseif ($this->transaction->t_type == 'F') {
            return $this->transaction->t_total_refund;
        }
    }

    public function checkIfReverseIsAllow()
    {
        if ($this->module == 'processbail') {
            if (($this->transaction->t_type == 'P'
                 || $this->transaction->t_type == 'PM'
                 || $this->transaction->t_type == 'PS') && $this->transaction->t_no_reversal != 1) {
                return true;
            }
        } else {
             if (($this->transaction->t_type == 'F'
                 || $this->transaction->t_type == 'A') && $this->transaction->t_no_reversal != 1) {
                return true;
            }
        }
        return false;
    }

}