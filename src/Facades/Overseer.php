<?php

namespace Cboxdk\StatamicOverseer\Facades;

use Illuminate\Support\Facades\Facade;

class Overseer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Cboxdk\StatamicOverseer\Overseer::class;
    }
}