<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAllow extends Model
{
    /**
     * [$table Db table name]
     * @var string
     */
    protected $table = 'users_allow';

    /**
     * [$timestamps description]
     * @var boolean
     */
    public $timestamps = false;

    public function scopeGetUserClearance($query, $currentUserId)
    {
        $currentUserId = (int) $currentUserId;
        return $query->where('ua_uid', '=', $currentUserId)->get();
    }
}
