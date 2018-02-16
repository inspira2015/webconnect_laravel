<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function scopeGetJailRecordsByCheckNumber($query, $checkNumber)
    {
        $checkNumber = (int) $checkNumber;
        return $query->where('j_check_number', 'like',   $checkNumber . '%')->get();
    }
}
