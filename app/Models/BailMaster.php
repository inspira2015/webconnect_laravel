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
}