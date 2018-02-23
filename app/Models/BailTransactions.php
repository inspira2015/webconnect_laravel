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

    protected $primaryKey = 'm_id';

    protected $fillable = [
                            'j_id',
                            'm_court_number'
                          ];
}