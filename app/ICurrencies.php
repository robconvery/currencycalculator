<?php
/**
 * Created by PhpStorm.
 * User: robertconvery
 * Date: 17/02/2018
 * Time: 21:58
 */

namespace App;

interface ICurrencies
{
    public function getList();
    public function getFirst();
    public function getCurrency($code);
}
