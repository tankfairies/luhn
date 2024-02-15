<?php

namespace Tests\unit\Generator;

use Codeception\Test\Unit;
use ReflectionProperty;
use Tankfairies\Luhn\Generator\AbstractGenerator;
use UnitTester;
use ReflectionException;

class AbstractGeneratorTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    /**
     * @throws ReflectionException
     */
    public function testSetLength()
    {
        $mock = new class extends AbstractGenerator {
            public function generate(): void
            {
                // ...
            }
        };

        $mock->setLength(5);

        $reflection = new ReflectionProperty($mock, 'charLength');
        $this->assertEquals(4, $reflection->getValue($mock));
    }

    /**
     * @throws ReflectionException
     */
    public function testGetToken()
    {
        $mock = new class extends AbstractGenerator {
            public function generate(): void
            {
                // ...
            }
        };
        $reflection = new ReflectionProperty($mock, 'token');
        $reflection->setValue($mock, 'USR-123');

        $response = $mock->getToken();
        $this->assertEquals('USR-123', $response);
    }
}
