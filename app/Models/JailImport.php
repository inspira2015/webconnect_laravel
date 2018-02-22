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

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    public function scopeGetJailRecordsLikeCheckNumber($query, $checkNumber)
    {
        $checkNumber = (int) $checkNumber;
        return $query->where('j_check_number', 'like', $checkNumber . '%')->get();
    }

    public function scopeGetJailRecordsByCheckNumber($query, $checkNumber)
    {
        $checkNumber = (int) $checkNumber;
        $jailRecords = DB::select("
                            SELECT 
                                      SUBSTRING_INDEX(j_index_number, '/', 1)  AS index_number,
                                      SUBSTRING_INDEX(j_index_number, '/', -1) AS index_year,
                                      bm.j_id                                  AS bm_j_id,
                                      ji.*
                            FROM      jail_import AS ji
                            LEFT JOIN bail_master AS bm ON bm.j_id = ji.j_id
                            WHERE 1
                            AND ji.j_check_number = ?", [$checkNumber]
                        );

        return $jailRecords;
    }
}
