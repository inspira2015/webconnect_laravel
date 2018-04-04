<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ExcelHelper extends Facade
{
    protected static function getFacadeAccessor() { return 'ExcelHelper'; }
}