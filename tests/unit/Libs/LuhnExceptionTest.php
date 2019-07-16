<?php

namespace Tests\Libs;

use \Codeception\Test\Unit;
use Tankfairies\Luhn\Libs\LuhnException;

class LuhnExceptionTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testException()
    {
        $this->tester->expectException(
            new LuhnException('this is a test'),
            function () {
                throw new LuhnException('this is a test');
            }
        );
    }
}
