<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class JailImport extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'jail_import';

    private $totalJailAmount;

    private $resultJailRecord;

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    /**
     * [scopeGetJailRecordsLikeCheckNumber description]
     * @param  [type] $query       [description]
     * @param  [type] $checkNumber [description]
     * @return [type]              [description]
     */
    public function scopeGetCheckNumbersLikeInput($query, $checkNumber)
    {
        $checkNumber = (int) $checkNumber;
        return $query->distinct()->select('j_check_number')->where('j_check_number', 'like', $checkNumber . '%')->get();
    }

    public function scopeGetJailRecordsByCheckNumber($query, $checkNumber)
    {
        $checkNumber = (int) $checkNumber;
        $jailRecords = DB::select("
                            SELECT    
                                      SUM(ji.j_bail_amount/100) as total,
                                      SUBSTRING_INDEX(ji.j_index_number, '/', 1)  AS index_number,
                                      SUBSTRING_INDEX(ji.j_index_number, '/', -1) AS index_year,
                                      CASE
                                            WHEN bm.j_check_number IS NOT NULL THEN 'duplicate-row'
                                            ELSE   ''
                                      END as duplicate,
                                     
                                      TRUNCATE(ji.j_bail_amount/100, 2)        AS bail_amount,
                                      ji.*
                            FROM      jail_import AS ji
                            LEFT JOIN bail_master AS bm ON bm.j_check_number       = ji.j_check_number
                                  AND SUBSTRING_INDEX(ji.j_index_number, '/', 1)   = bm.m_index_number
                                  AND  SUBSTRING_INDEX(ji.j_index_number, '/', -1) = bm.m_index_year  
                            WHERE 1
                            AND ji.j_check_number = ?
                            GROUP BY ji.j_id WITH ROLLUP ", [$checkNumber]
                        );
        if (!empty($jailRecords)) {
          $totalRow = array_pop($jailRecords);
          $this->resultJailRecord = $jailRecords;
          $this->totalJailAmount = $totalRow->total;
        }
        return $jailRecords;
    }

    public function scopeGetJailRecordSplitById($query, $id)
    {
        $id = (int) $id;
        $jailRecords = DB::select("
                                    SELECT    
                                           SUBSTRING_INDEX(ji.j_index_number, '/', 1)  AS index_number,
                                           SUBSTRING_INDEX(ji.j_index_number, '/', -1) AS index_year,
                                           TRUNCATE(ji.j_bail_amount/100, 2)        AS bail_amount,
                                           ji.*
                                    FROM   jail_import AS ji
                                    WHERE  1
                                    AND    ji.j_id      =  ?", [$id]
                                 );
        if (!empty($jailRecords)) {
          return $jailRecords[0];
        }
        return $jailRecords;
    }

    public function scopeGetJailRecordsTotalByCheckNumber($query)
    {
        return round($this->totalJailAmount, 2);
    }


    public function scopeGetAllJailIds($query)
    {
      $resultIdArray = [];
      foreach ($this->resultJailRecord AS $key => $value) {
        $resultIdArray[] = $value->j_id;
      }
      return $resultIdArray;
    }

}
