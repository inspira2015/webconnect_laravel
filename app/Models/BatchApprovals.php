<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchApprovals extends Model
{
    /**
	 * [$table Db table name]
	 * @var string
	 */
    protected $table = 'batch_approvals';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;


    public function scopeGetApprovalsByBatchId($query, $batchId)
    {
        $batchId = (int) $batchId;
        return $query->where('bg_id', '=', $batchId)->get();
    }
}
