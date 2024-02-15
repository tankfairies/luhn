<?php

namespace Tests\unit\Generator\Adapter;

use Codeception\Test\Unit;
use Tankfairies\Luhn\Generator\Adapter\SimpleAlnum;
use UnitTester;

class SimpleAlnumTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    public function testGenerate()
    {
        $simpleAlnum = new SimpleAlnum();
        $simpleAlnum->setLength(4);

        $simpleAlnum->generate();

        $response = $simpleAlnum->getToken();
        $this->assertEquals(3, mb_strlen($response));
    }
}
