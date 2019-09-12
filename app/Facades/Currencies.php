<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Currencies extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SourceCurrencies';
    }
}
