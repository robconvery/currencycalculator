<?php
namespace App;

use http\Exception\RuntimeException;
use App\ICurrency;

class Currency implements ICurrency
{
    private $data;
    private $observers = [];

    /**
     * Currency constructor.
     * @param array $data
     * @throws \Exception
     */
    public function __construct(array $data)
    {
        $this->validate($data);
        $this->exchangeArray($data);
    }

    /**
     * Load currency data
     * @param array $data
     * @return $this
     */
    protected function exchangeArray(array $data)
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
        return $this;
    }

    /**
     * validation of currency data
     * @param array $data
     * @throws \Exception
     */
    protected function validate(array $data)
    {
        if (!isset($data['targetName'])) {
            throw new \Exception('Missing attribute targetName');
        }

        if (!isset($data['exchangeRate'])) {
            throw new \Exception('Missing attribute exchangeRate');
        }

        if ($data['exchangeRate'] == 0) {
            throw new \Exception('Invalid exchange rate exchangeRate');
        }
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $value = null;
        // ensure that these values are returned as
        // floats
        if ($name == 'value' || $name == 'exchangeRate') {
            if (array_key_exists($name, $this->data)) {
                $value = (float)$this->data[$name];
            }
        } elseif (array_key_exists($name, $this->data)) {
            $value = $this->data[$name];
        }
        return $value;
    }

    /**
     * attach comparison currency
     * @param Currency $Currency
     */
    public function attachCurrency(Currency $Currency)
    {
        $this->observers[] = $Currency;
    }

    /**
     * Returns currency code
     * @return string
     * @throws \Exception
     */
    public function getTarget()
    {
        if (!isset($this->data['targetName'])) {
            throw new \Exception('Missing target name');
        }
        return $this->data['targetName'];
    }

    public function update(Currency $master)
    {
        $this->data['value'] = $this->updateValue($master);
    }

    /**
     * Updates the value based on the comparison with
     * the master currency
     * @param Currency $master
     * @return float|int
     */
    private function updateValue(Currency $master)
    {
        return $master->getBase() * $this->exchangeRate;
    }

    /**
     * Convert to decimal that can be compared with
     * other currencies
     * @return float|int
     */
    protected function getBase()
    {
        return $this->value / (float)$this->exchangeRate;
    }

    /**
     * Add the currency value
     * @param $value
     * @return $this
     */
    public function addValue($value)
    {
        $this->data['value'] = $value;
        return $this;
    }

    public function getObservers()
    {
        return $this->observers;
    }

    /**
     * For each the attached currencies update the
     * value
     * @return $this
     */
    public function notify()
    {
        foreach ($this->getObservers() as $currency) {
            $currency->update($this);
        }
        return $this;
    }

    public function calculate()
    {
        $this->notify();
        /*
        $results['currencies'][$this->getTarget()] = [
            'code' => $this->getTarget(),
            'value' => $this->value
        ];
        foreach ($this->getObservers() as $currency) {
            // if (!array_key_exists('currencies', $results)) {
            //    $results['currencies'] = [];
            //}
            $results['currencies'][$currency->getTarget()] = [
                'code' => $currency->getTarget(),
                'value' => round($currency->value, 2)
            ];
        }
        return [$results];
        */
    }
}
