<?php
/**
 * Created by PhpStorm.
 * User: robertconvery
 * Date: 03/02/2018
 * Time: 23:11
 */

namespace App;

use App\CurrencyGateway;
use Illuminate\Support\Facades\App;
use App\Currency;

class Currencies implements ICurrencies
{
    private $gateway;
    private $currency = [];

    /**
     * Currencies constructor.
     * @param \App\CurrencyGateway $CurrencyGateway
     */
    public function __construct(CurrencyGateway $CurrencyGateway)
    {
        $this->gateway = $CurrencyGateway;
    }

    /**
     * @param \App\CurrencyGateway $gateway
     * @return $this
     * @throws \Exception
     */
    protected function initialise(CurrencyGateway $gateway)
    {
        $currencies = $gateway->getCurrencies();

        usort($currencies['item'], function ($a, $b) {
            return trim($a['targetName']) <=> trim($b['targetName']);
        });

        $base = current($currencies['item']);
        $baseCurrency['item'][] = [
            "pubDate" => $base['pubDate'],
            "baseCurrency" => $base['baseCurrency'],
            "baseName" => $base['baseName'],
            "targetCurrency" => $base['baseCurrency'],
            "targetName" => $base['baseName'],
            "exchangeRate" => 1
        ];

        $this->load($baseCurrency);
        $this->load($currencies);

        return $this;
    }

    /**
     * Receives array of currency data, loads into
     * currency class and stores as array
     * @param array $data
     * @return $this
     * @throws \Exception
     */
    private function load(array $data)
    {
        if (isset($data['item'])) {
            foreach ($data['item'] as $currency) {
                if (!isset($currency['targetCurrency'])) {
                    abort(500, 'missing target currency');
                }
                $this->currency[$currency['targetCurrency']] = new Currency($currency);
            }
        }
        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getList()
    {
        if (empty($this->currency)) {
            $this->initialise($this->gateway);
        }
        return $this->currency;
    }

    /**
     * @return Currency
     * @throws \Exception
     */
    public function getFirst()
    {
        if (empty($this->currency)) {
            $this->initialise($this->gateway);
        }
        return current($this->currency);
    }

    /**
     * Returns currency data for specified currency
     * @param $code
     * @throws \Exception
     * @return Currency
     */
    public function getCurrency($code)
    {
        if (!isset($this->currency[$code])) {
            throw new \Exception('Missing currency ' . $code);
        }
        return $this->currency[$code];
    }
}
