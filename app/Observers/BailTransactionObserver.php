<?php

namespace App\Observers;

use App\Models\BailTransactions;

class BailTransactionObserver
{
    public function creating(BailTransactions $bailTransaction)
    {
        return $bailTransaction->t_comments = 'observer';
    }
}