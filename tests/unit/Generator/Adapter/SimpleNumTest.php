<?php

namespace Tests\Generator\Adapter;

use \Codeception\Test\Unit;
use Tankfairies\Luhn\Generator\Adapter\SimpleNum;

class SimpleNumTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $simpleNum;
    
    protected function _before()
    {
        $this->simpleNum = new SimpleNum();
    }

    protected function _after()
    {
        $this->simpleNum = null;
    }

    public function testGenerate()
    {
        $this->simpleNum->setLength(4);

        $this->simpleNum->generate();

        $response = $this->simpleNum->getToken();
        $this->assertEquals(4, mb_strlen($response));
    }
}
