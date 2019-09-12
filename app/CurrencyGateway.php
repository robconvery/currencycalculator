<?php
/**
 * Created by PhpStorm.
 * User: robertconvery
 * Date: 03/02/2018
 * Time: 22:22
 */

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class CurrencyGateway
{
    protected $endPoint = 'http://www.floatrates.com/daily/gbp.xml';

    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrencies()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', $this->getEndPoint());
            $xml = simplexml_load_string($response->getBody()->getContents());
            $json = json_encode($xml);
            return json_decode($json, true);
        } catch (ClientException $e) {
            return [];
        }
    }

    /**
     * @return string
     */
    protected function getEndPoint()
    {
        return $this->endPoint;
    }
}
