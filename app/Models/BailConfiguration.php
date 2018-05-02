<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BailConfiguration extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'bail_configuration';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    protected $primaryKey = 'bc_id';

    protected $fillable = [
                            'j_check_number',
                            'm_court_number'
                          ];

    public function scopeGetFeePercentaje($query)
    {
        return $query->where('bc_category', '=', 'bail_fee')
                     ->where('bc_type', '=', 'regular')->get();
    }

    public function scopeGetStateIdByAbv($query, $stateAbv)
    {
        return $query->where('bc_category', '=', 'states')
                     ->where('bc_type', '=', $stateAbv)->get()->first();
    }

    public function scopeGetStateAbvById($query, $stateId)
    {
        return $query->where('bc_category', '=', 'states')
                     ->where('bc_id', '=', $stateId)->get()->first()->bc_type;
    }

}