<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BailMaster extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'bail_master';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    protected $primaryKey = 'm_id';

    protected $fillable = [
                            'j_check_number',
                            'm_court_number'
                          ];

    public function scopeValidateUniqueRecord($query, array $indexArray)
    {
        $indexYear = (int) $indexArray['index_year'];
        $indexNumber = (string) $indexArray['index_number'];
        return $query->where('m_index_number', '=', $indexNumber)
                     ->where('m_index_year', '=', $indexYear)->get()->toArray();
    }

    public function scopeGetMasterRecordById($query, $masterId)
    {
        return $query->where('m_id', '=', $masterId)->get();
    }

    public function BailTransactions()
    {
        return $this->hasOne('App\Models\BailTransactions', 'm_id');
    }

    public function Courts()
    {
        return $this->hasOne('App\Models\Courts', 'c_id', 'm_court_number');
    }

    public function BailConfiguration()
    {
        return $this->hasOne('App\Models\BailConfiguration', 'bc_id', 'm_surety_state');

    }
}