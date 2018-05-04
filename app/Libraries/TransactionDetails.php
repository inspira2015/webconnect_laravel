<?php
namespace App\Libraries;


class TransactionDetails
{
	private $transactionArray;
	private $t_debit_credit_index;
    private $t_numis_doc_id;
    private $t_fee_percentage;
    private $t_total_refund;
    private $t_amount;
    private $t_reversal_index;
    private $t_check_number;
    private $t_mult_check_index;
    private $t_created_at;

	public function __construct($objDetails = false)
	{
		$this->transactionArray['m_id'] = 0;
		$this->transactionArray['t_debit_credit_index'] = 'O';
		$this->transactionArray['t_numis_doc_id'] = 1;
		$this->transactionArray['t_fee_percentage'] = 0;
		$this->transactionArray['t_total_refund'] = 0;
		$this->transactionArray['t_amount'] = 0;
		$this->transactionArray['t_reversal_index'] = 0;
		$this->transactionArray['t_check_number'] = 'NIFS';
		$this->transactionArray['t_mult_check_index'] = 0;
		$this->transactionArray['t_created_at'] = date('Y-m-d G:i:s');
		$this->setObjDetails($objDetails);
	}

	public function setObjDetails($objDetails)
	{
		if (!is_object($objDetails)) {
			return;
		}
		foreach ($objDetails as $key => $value) {
			$this->transactionArray[$key] = $value;
		}
	}

	public function setTransactionDetails($key, $value)
	{
		$this->transactionArray[$key] = $value;
		return $this;
	}

	public function setTransactionDetailsArray($transaction)
	{
		if (!is_object($transaction)) {
			throw new Exception('Transaction variable is not a valid object.');
		}

		foreach ($transaction as $key => $value) {
			$this->transactionArray[$key] = $value;
		}
		return $this;
	}

	public function getTransaction($key)
	{
		if (isset($this->transactionArray[$key])) {
			return $this->transactionArray[$key];
		}
		return false;
	}

	public function getTransactionArray()
	{
		return $this->transactionArray;
	}

}