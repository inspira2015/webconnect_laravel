<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BailTransactions extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'bail_transactions';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    protected $primaryKey = 't_id';

    protected $fillable = [
                            't_id',
                            'm_court_number'
                          ];

}