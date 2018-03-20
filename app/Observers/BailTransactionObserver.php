<?php

namespace App\Observers;

use App\Models\BailTransactions;
use App\Models\BailMaster;
use Auth;

class BailTransactionObserver
{
    public function creating(BailTransactions $bailTransaction)
    {
    	$user = Auth::user();
    	$bailTransaction->t_last_update_user = $user->id;
    }

}