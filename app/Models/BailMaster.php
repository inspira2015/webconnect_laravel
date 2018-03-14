<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function scopeGetArrayIndexNumberLike($query, $indexNumber)
    {
        return $query->where(DB::raw("concat_ws('/', m_index_number, m_index_year)"), 'like', $indexNumber .'%')->get()->toArray();
    }

    public function scopeGetArrayDefendantNameLike($query, $defendatName)
    {
        return $query->where(DB::raw("concat_ws(' ', m_def_first_name, m_def_last_name)"), 'like', $defendatName . "%")->get()->toArray();
    }

    public function scopeGetArraySuretyNameLike($query, $suretyName)
    {
        return $query->where(DB::raw("concat_ws(' ', m_surety_first_name, m_surety_last_name)"), 'like', $suretyName . "%")->get()->toArray();
    }

    public function scopeGetIndexNumberLike($query, $indexNumber)
    {
        return $query->where(DB::raw("concat_ws('/', m_index_number, m_index_year)"), 'like', $indexNumber .'%')->get();
    }

    public function scopeGetDefendantNameLike($query, $defendatName)
    {
        return $query->where(DB::raw("concat_ws(' ', m_def_first_name, m_def_last_name)"), 'like', $defendatName . "%")->get();
    }

    public function scopeGetMasterRecordById($query, $masterId)
    {
        return $query->where('m_id', '=', $masterId)->get();
    }

    public function BailTransactions()
    {
        return $this->hasMany('App\Models\BailTransactions', 'm_id');
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