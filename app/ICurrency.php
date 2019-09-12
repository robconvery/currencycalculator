<?php
/**
 * Created by PhpStorm.
 * User: robertconvery
 * Date: 04/02/2018
 * Time: 13:26
 */

namespace App;

use App\Currency;

interface ICurrency
{
    public function attachCurrency(Currency $Currency);
    public function getTarget();
    public function update(Currency $currency);
    public function notify();
}
