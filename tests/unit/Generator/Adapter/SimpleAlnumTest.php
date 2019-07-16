<?php

namespace Tests\Generator\Adapter;

use \Codeception\Test\Unit;
use Tankfairies\Luhn\Generator\Adapter\SimpleAlnum;

class SimpleAlnumTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $simpleAlnum;
    
    protected function _before()
    {
        $this->simpleAlnum = new SimpleAlnum();
    }

    protected function _after()
    {
        $this->simpleAlnum = null;
    }

    public function testGenerate()
    {
        $this->simpleAlnum->setLength(4);

        $this->simpleAlnum->generate();

        $response = $this->simpleAlnum->getToken();
        $this->assertEquals(4, mb_strlen($response));
    }
}
