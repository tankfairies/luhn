<?php

namespace Tests\Libs;

use \Codeception\Test\Unit;
use Luhn\Libs\AlnumBaseConverter;
use ReflectionProperty;

class AlnumBaseConverterTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $alnumBaseConverter;

    protected function _before()
    {
        $this->alnumBaseConverter = new AlnumBaseConverter();
    }

    protected function _after()
    {
        $this->alnumBaseConverter = null;
    }

    public function testDefaultBaseValue()
    {
        $reflection = new ReflectionProperty('Luhn\Libs\AlnumBaseConverter', 'base');
        $reflection->setAccessible(true);
        $this->assertEquals(10, $reflection->getValue($this->alnumBaseConverter));
    }

    public function testSetBaseValue()
    {
        $this->alnumBaseConverter->setBase(16);

        $reflection = new ReflectionProperty('Luhn\Libs\AlnumBaseConverter', 'base');
        $reflection->setAccessible(true);
        $this->assertEquals(16, $reflection->getValue($this->alnumBaseConverter));
    }

    public function testSetNumberArray()
    {
        $this->alnumBaseConverter->setNumberArray(['1', '2', '3']);

        $reflection = new ReflectionProperty('Luhn\Libs\AlnumBaseConverter', 'numberArray');
        $reflection->setAccessible(true);
        $this->assertEquals(['1', '2', '3'], $reflection->getValue($this->alnumBaseConverter));
    }

    public function testSetNumberString()
    {
        $this->alnumBaseConverter->setNumberString(654);

        $reflection = new ReflectionProperty('Luhn\Libs\AlnumBaseConverter', 'numberString');
        $reflection->setAccessible(true);
        $this->assertEquals(654, $reflection->getValue($this->alnumBaseConverter));
    }

    public function testStringToNumberArray()
    {
        $this->alnumBaseConverter->setNumberString(654);

        $response = $this->alnumBaseConverter->stringToNumberArray();

        $this->assertEquals(['6', '5', '4'], $response);
    }

    public function testNumberArrayToString()
    {
        $this->alnumBaseConverter->setNumberArray(['1', '2', '3']);

        $response = $this->alnumBaseConverter->numberArrayToString();

        $this->assertEquals('123', $response);
    }
}
