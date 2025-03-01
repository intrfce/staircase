<?php

namespace Intrfce\Staircase\Facades;

use Illuminate\Support\Facades\Facade;

class Staircase extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'staircase';
    }
}
