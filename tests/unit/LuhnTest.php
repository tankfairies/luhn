<?php

namespace Tests;

use \Codeception\Test\Unit;
use Luhn\Generator\GeneratorInterface;
use Luhn\Libs\LuhnException;
use Luhn\Luhn;
use ReflectionProperty;
use \Codeception\Util\Debug;

class LuhnTest extends Unit
{
    protected $luhn;

    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->luhn = new Luhn();
    }

    protected function _after()
    {
        $this->luhn = null;
    }

    public function testNumericConst()
    {
        $this->assertEquals(1, Luhn::NUMERIC);
    }

    public function testAlnumConst()
    {
        $this->assertEquals(0, Luhn::ALPHA_NUMERIC);
    }

    public function testSetTemplateAlnumChars()
    {
        $this->luhn->setTemplate('AA-####');

        $reflection = new ReflectionProperty('Luhn\Luhn', 'stringLength');
        $reflection->setAccessible(true);
        $this->assertEquals(4, $reflection->getValue($this->luhn));

        $reflection = new ReflectionProperty('Luhn\Luhn', 'format');
        $reflection->setAccessible(true);
        $this->assertEquals(['A', 'A', '-', '#', '#', '#', '#' ], $reflection->getValue($this->luhn));
    }

    public function testSetTemplateNumericChars()
    {
        $this->luhn->setTemplate('LL-####');

        $reflection = new ReflectionProperty('Luhn\Luhn', 'stringLength');
        $reflection->setAccessible(true);
        $this->assertEquals(4, $reflection->getValue($this->luhn));

        $reflection = new ReflectionProperty('Luhn\Luhn', 'format');
        $reflection->setAccessible(true);
        $this->assertEquals(['L', 'L', '-', '#', '#', '#', '#'], $reflection->getValue($this->luhn));
    }

    public function testSetTemplateNonAlnumChars()
    {
        $this->luhn->setTemplate('LLL-###');

        $reflection = new ReflectionProperty('Luhn\Luhn', 'stringLength');
        $reflection->setAccessible(true);
        $this->assertEquals(3, $reflection->getValue($this->luhn));

        $reflection = new ReflectionProperty('Luhn\Luhn', 'format');
        $reflection->setAccessible(true);
        $this->assertEquals(['L', 'L', 'L', '-', '#', '#', '#', ], $reflection->getValue($this->luhn));
    }

    public function testSetTemplateSingleChar()
    {
        $this->tester->expectException(
            new LuhnException('Template must contain at least 2 # substitutes.'),
            function () {
                $this->luhn->setTemplate('#');
            }
        );
    }

    public function testSetPostfixTypeNumeric()
    {
        $this->luhn->setTemplate('N#-####');

        $this->luhn->setPostfixType(Luhn::NUMERIC);

        $reflection = new ReflectionProperty('Luhn\Luhn', 'generator');
        $reflection->setAccessible(true);
        $this->assertInstanceOf(GeneratorInterface::class, $reflection->getValue($this->luhn));
    }

    public function testSetPostfixTypeAplhaNumeric()
    {
        $this->luhn->setTemplate('L##-###');

        $this->luhn->setPostfixType(Luhn::ALPHA_NUMERIC);

        $reflection = new ReflectionProperty('Luhn\Luhn', 'generator');
        $reflection->setAccessible(true);
        $this->assertInstanceOf(GeneratorInterface::class, $reflection->getValue($this->luhn));
    }

    public function testSetPostfixTypeInvalid()
    {
        $this->tester->expectException(
            new LuhnException('Unknown adapter'),
            function () {
                $this->luhn->setPostfixType(3);
            }
        );
    }

    public function testSetPostfixTypeInvalid2()
    {
        $this->tester->expectException(
            \TypeError::class,
            function () {
                $this->luhn->setPostfixType('fail');
            }
        );
    }

    public function testGenerateNumeric()
    {
        $this->luhn->setTemplate('USR-####-####');
        $this->luhn->setPostfixType(Luhn::NUMERIC);

        $token = $this->luhn->generate();
        //add -d to show
        Debug::debug($token);

        $parts = explode('-', $token);

        $this->assertEquals('USR', $parts[0]);
        $this->assertEquals(4, mb_strlen($parts[1]));
        $this->assertEquals(5, mb_strlen($parts[2]));
    }

    public function testGenerateAlphaNumeric()
    {
        $this->luhn->setTemplate('USR-####-####');
        $this->luhn->setPostfixType(Luhn::ALPHA_NUMERIC);

        $token = $this->luhn->generate();
        Debug::debug($token);

        $parts = explode('-', $token);

        $this->assertEquals('USR', $parts[0]);
        $this->assertEquals(4, mb_strlen($parts[1]));
        $this->assertEquals(5, mb_strlen($parts[2]));
    }

    public function testValidateValidNumericLuhn()
    {
        $response = $this->luhn->validate('USR-6560-73597');

        $this->assertTrue($response);
        // USR-6560-73597
        // USR-f36x-x79n9
    }

    public function testValidateValidAlphaNumericLuhn()
    {
        $response = $this->luhn->validate('USR-f36x-x79n9');

        $this->assertTrue($response);
    }

    public function testValidateInvalidLuhn()
    {
        $response = $this->luhn->validate('USR-111-1119');

        $this->assertFalse($response);
    }
}
