<?php

namespace App\Traits;

trait Sanitise
{
    /**
     * @param array $inputs
     * @return array
     */
    public function sanitise(array $inputs)
    {
        foreach ($inputs as $key => $value) {
            if (is_array($value)) {
                $inputs[$key] = $this->sanitise($value);
            } else {
                $inputs[$key] = $value === null ? null : $this->cleanse($value);
            }
        }
        return $inputs;
    }

    /**
     * @param $str
     * @return string
     */
    public function cleanse(string $str): string
    {
        return strip_tags($str);
    }
}
