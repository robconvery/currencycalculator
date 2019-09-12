<?php

namespace Tests\Unit;

use App\Currency;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyTest extends TestCase
{
    /**
     * @param $data
     * @param $message
     * @throws \Exception
     * @covers Currency::validate
     * @dataProvider dataValidate
     * @group currency
     * @return void
     */
    public function testValidate($data, $message)
    {
        $this->expectException(\Exception::class, $message);
        new Currency($data);
    }

    /**
     * @return array
     */
    public function dataValidate()
    {
        return [
            [['targetName' => 'boo', 'exchangeRate' => 0], 'exchangeRate is 0'],
            [['exchangeRate' => 1], 'Missing targetName'],
            [['targetName' => 'foo'], 'Missing exchangeRate']
        ];
    }

    /**
     * @covers Currency::getTarget
     * @dataProvider dataGetTarget
     * @group currency
     * @param $expected
     * @param $data
     * @param $message
     * @throws \Exception
     */
    public function testGetTarget($expected, $data, $message)
    {
        $Currency = new Currency($data);
        $this->assertEquals($expected, $Currency->getTarget(), $message);
    }

    /**
     * @return array
     */
    public function dataGetTarget()
    {
        return [
            [
                'boo',
                ['targetName' => 'boo', 'exchangeRate' => 1],
                'Test target name is returned correctly'
            ]
        ];
    }
}
