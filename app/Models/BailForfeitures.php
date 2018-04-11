<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BailForfeitures extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'bail_forfeitures';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    protected $primaryKey = 'bf_id';

    protected $fillable = [
                            'bf_id',
                            'bf_create_at',
                            'bf_updated_at',
                            'm_id'
                          ];

    public function scopeGetForfeitureReport($query)
    {
        return $query->where('bf_processed', '=', '0')->get();
    }

    public function scopeGetForfeitureReportByDate($query, $date)
    {
        return $query->where('bf_processed', '=', '0')
                     ->where('bf_updated_at', '<=', $date)->get();
    }

    public function scopeGetProcessedForfeitureReportByDate($query, $date)
    {
        return $query->where('bf_processed', '=', '1')->get();
    }

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function BailMaster()
    {
        return $this->hasOne('App\Models\BailMaster', 'm_id', 'm_id');
    }

    public function getReportDate()
    {
        $newDate = new Carbon($this->bf_updated_at);
        $newDate->addDays(45);
        return $newDate->format('Y-m-d');
    }

    public function getBfUpdatedAtAttribute($value)
    {
        $newDate = new Carbon($value);
        return $newDate->format('Y-m-d');
    }
}