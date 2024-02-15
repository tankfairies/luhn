<?php

namespace Tests\unit\Libs;

use \Codeception\Test\Unit;
use Tankfairies\Luhn\Libs\LuhnException;
use UnitTester;

class LuhnExceptionTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testException()
    {
        $this->tester->expectThrowable(
            new LuhnException('this is a test'),
            function () {
                throw new LuhnException('this is a test');
            }
        );
    }
}
