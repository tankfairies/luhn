<?php

namespace Tests\StringGenerator;

use \Codeception\Test\Unit;
use Codeception\Util\Debug;
use Mockery;
use ReflectionProperty;

class AbstractGeneratorTest extends Unit
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

    public function testSetLength()
    {
        $mock = $this->getMockForAbstractClass('Tankfairies\Luhn\Generator\AbstractGenerator');
        $mock->setLength(5);

        $reflection = new ReflectionProperty($mock, 'charLength');
        $reflection->setAccessible(true);
        $this->assertEquals(5, $reflection->getValue($mock));
    }

    public function testGetToken()
    {
        $mock = $this->getMockForAbstractClass('Tankfairies\Luhn\Generator\AbstractGenerator');

        $reflection = new ReflectionProperty($mock, 'token');
        $reflection->setAccessible(true);
        $reflection->setValue($mock, 'USR-123');

        $response = $mock->getToken();
        $this->assertEquals('USR-123', $response);
    }
}
