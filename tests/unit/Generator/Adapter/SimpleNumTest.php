<?php

namespace Tests\unit\Generator\Adapter;

use Codeception\Test\Unit;
use Tankfairies\Luhn\Generator\Adapter\SimpleNum;
use UnitTester;

class SimpleNumTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    public function testGenerate()
    {
        $simpleNum = new SimpleNum();
        $simpleNum->setLength(4);

        $simpleNum->generate();

        $response = $simpleNum->getToken();
        $this->assertEquals(3, mb_strlen($response));
    }
}
