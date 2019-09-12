<?php

namespace App;

use Illuminate\Support\Facades\Cache;

class CurrenciesCache implements ICurrencies
{

    protected $next;

    const PERIOD = 10;

    /**
     * CurrenciesCache constructor.
     * @param ICurrencies $next
     */
    public function __construct(ICurrencies $next)
    {
        $this->next = $next;
    }

    /**
     * @return array
     */
    public function getList()
    {
        $key = md5(__METHOD__);
        return Cache::remember($key, static::PERIOD, function () {
            return $this->next->getList();
        });
    }

    /**
     * @return App/Currency
     */
    public function getFirst()
    {
        // no need to pass though.
        $currencies = $this->getList();
        return current($currencies);
    }

    /**
     * @param $code
     * @return mixed
     * @throws \Exception
     */
    public function getCurrency($code)
    {
        // no need to pass though.
        $currencies = $this->getList();
        if (!isset($currencies[$code])) {
            throw new \Exception('Missing currency ' . $code);
        }
        return $currencies[$code];
    }
}
