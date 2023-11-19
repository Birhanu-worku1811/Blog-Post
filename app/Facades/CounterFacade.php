<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * A Facade to do contract
 * @method static int increment (string $key, array $tags = null)
 */
class CounterFacade extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return "App\Contracts\CounterContract";
    }
}
