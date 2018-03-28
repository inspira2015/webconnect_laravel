<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PostedData extends Facade
{
    protected static function getFacadeAccessor() { return 'PostedData'; }
}
