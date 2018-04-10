<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CreateTransaction extends Facade
{
    protected static function getFacadeAccessor() { return 'CreateTransaction'; }
}