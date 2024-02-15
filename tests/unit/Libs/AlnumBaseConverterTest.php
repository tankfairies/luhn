<?php

namespace Tests\unit\Libs;

use Codeception\Test\Unit;
use UnitTester;
use Tankfairies\Luhn\Libs\AlnumBaseConverter;
use ReflectionProperty;

class AlnumBaseConverterTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    public function testDefaultBaseValue()
    {
        $alnumBaseConverter = new AlnumBaseConverter();
        $reflection = new ReflectionProperty('Tankfairies\Luhn\Libs\AlnumBaseConverter', 'base');
        $this->assertEquals(10, $reflection->getValue($alnumBaseConverter));
    }

    public function testSetBaseValue()
    {
        $alnumBaseConverter = new AlnumBaseConverter();
        $alnumBaseConverter->setBase(16);

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Libs\AlnumBaseConverter', 'base');
        $this->assertEquals(16, $reflection->getValue($alnumBaseConverter));
    }

    public function testSetNumberString()
    {
        $alnumBaseConverter = new AlnumBaseConverter();
        $alnumBaseConverter->setNumberString(654);

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Libs\AlnumBaseConverter', 'numberString');
        $this->assertEquals(654, $reflection->getValue($alnumBaseConverter));
    }

    public function testStringToNumberArray()
    {
        $alnumBaseConverter = new AlnumBaseConverter();
        $alnumBaseConverter->setNumberString(654);

        $response = $alnumBaseConverter->stringToNumberArray();

        $this->assertEquals(['6', '5', '4'], $response);
    }
}
