<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function BailMaster()
    {
        return $this->hasOne('App\Models\BailMaster', 'm_id', 'bf_id');
    }
}