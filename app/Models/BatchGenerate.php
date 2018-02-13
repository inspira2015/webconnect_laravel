<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchGenerate extends Model
{
	/**
	 * [$table Db table name]
	 * @var string
	 */
    protected $table = 'batch_generate';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;


    public function scopeGetBatchJobByDate($query, $date)
    {
        $queryDate = $date;
        return $query->where('bg_create_at', '=', $queryDate)->get();
    }
}
