<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class BailComments extends Model
{
    use SoftDeletes;

    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'bail_comments';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    public $fillable = [
    					 'foreign_table',
    					 'foreign_id'
    				   ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function scopeGetBailMasterComments($query, $bailMasterId)
    {
        return $query->where('foreign_table', '=', 'bail_master')
                     ->where('foreign_id', '=', $bailMasterId)->get();
    }

    public function getDateForComment()
    {
        $dt = new Carbon($this->created_at);
		$stringDate = $dt->toFormattedDateString(); // Dec 25, 1975
        return 'on ' . $stringDate;
    }
}