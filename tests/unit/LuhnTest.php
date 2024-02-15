<?php

namespace Tests\unit;

use Codeception\Test\Unit;
use Tankfairies\Luhn\Generator\Adapter\SimpleAlnum;
use Tankfairies\Luhn\Generator\Adapter\SimpleNum;
use Tankfairies\Luhn\Generator\GeneratorInterface;
use Tankfairies\Luhn\Libs\LuhnException;
use Tankfairies\Luhn\Luhn;
use ReflectionProperty;
use UnitTester;
use Exception;

class LuhnTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testSetTemplateAlnumChars()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA12',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('AA-####');

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'stringLength');
        $this->assertEquals(4, $reflection->getValue($luhn));

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'format');
        $this->assertEquals(['A', 'A', '-', '#', '#', '#', '#' ], $reflection->getValue($luhn));
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testSetTemplateNumericChars()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA12',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('LL-####');

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'stringLength');
        $this->assertEquals(4, $reflection->getValue($luhn));

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'format');
        $this->assertEquals(['L', 'L', '-', '#', '#', '#', '#'], $reflection->getValue($luhn));
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testSetTemplateNonAlnumChars()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA1',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('LLL-###');

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'stringLength');
        $this->assertEquals(3, $reflection->getValue($luhn));

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'format');
        $this->assertEquals(['L', 'L', 'L', '-', '#', '#', '#', ], $reflection->getValue($luhn));
    }

    /**
     * @throws Exception
     */
    public function testSetTemplateSingleChar()
    {
        $simpleAlnum = $this->make(SimpleAlnum::class);
        $luhn = new Luhn($simpleAlnum);
        $this->tester->expectThrowable(
            new LuhnException('Template must contain at least 2 # substitutes.'),
            function () use ($luhn) {
                $luhn->setTemplate('#');
            }
        );
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testSetPostfixTypeNumeric()
    {
        $simpleNum = $this->make(
            SimpleNum::class,
            [
                'setLength' => $this->make(SimpleNum::class),
                'getToken' => '12345',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleNum);
        $luhn->setTemplate('N#-####');

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'generator');
        $this->assertInstanceOf(GeneratorInterface::class, $reflection->getValue($luhn));
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testSetPostfixTypeAplhaNumeric()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA1D3',
                'generate' => null,
            ]
        );
        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('L##-###');

        $reflection = new ReflectionProperty('Tankfairies\Luhn\Luhn', 'generator');
        $this->assertInstanceOf(GeneratorInterface::class, $reflection->getValue($luhn));
    }

    /**
     * @throws Exception
     */
    public function testGenerateWithoutTemplate()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA1',
                'generate' => null,
            ]
        );
        $luhn = new Luhn($simpleAlnum);
        $this->tester->expectThrowable(
            new LuhnException('Template not set'),
            function () use ($luhn) {
                $luhn->generate();
            }
        );
    }

    public function testGenerateWithoutType()
    {
        $this->tester->expectThrowable(
            new LuhnException('Generator not set'),
            function () {
                $luhn = new Luhn();
                $luhn->setTemplate('USR-####-####');
                $luhn->generate();
            }
        );
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testGenerateNumeric()
    {
        $simpleNum = $this->make(
            SimpleNum::class,
            [
                'setLength' => $this->make(SimpleNum::class),
                'getToken' => '12345678',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleNum);
        $luhn->setTemplate('USR-####-####');

        $token = $luhn->generate();

        $parts = explode('-', $token);

        $this->assertEquals('USR', $parts[0]);
        $this->assertEquals(4, mb_strlen($parts[1]));
        $this->assertEquals(4, mb_strlen($parts[2]));
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testGenerateAlphaNumeric()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA1D1E45',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('USR-####-####');

        $token = $luhn->generate();

        $parts = explode('-', $token);

        $this->assertEquals('USR', $parts[0]);
        $this->assertEquals(4, mb_strlen($parts[1]));
        $this->assertEquals(4, mb_strlen($parts[2]));
    }

    /**
     * @throws LuhnException
     * @throws Exception
     */
    public function testGenerateAlphaNumeric2()
    {
        $simpleAlnum = $this->make(
            SimpleAlnum::class,
            [
                'setLength' => $this->make(SimpleAlnum::class),
                'getToken' => 'EA1D241',
                'generate' => null,
            ]
        );

        $luhn = new Luhn($simpleAlnum);
        $luhn->setTemplate('USR-####-###');

        $token = $luhn->generate();

        $parts = explode('-', $token);

        $this->assertEquals('USR', $parts[0]);
        $this->assertEquals(4, mb_strlen($parts[1]));
        $this->assertEquals(3, mb_strlen($parts[2]));
    }

    public function testValidateValidNumericLuhn()
    {
        $luhn = new Luhn();
        $response = $luhn->validate('USR-6560-73597');

        $this->assertTrue($response);
        // USR-6560-73597
        // USR-f36x-x79n9
    }

    public function testValidateValidAlphaNumericLuhn()
    {
        $luhn = new Luhn();
        $response = $luhn->validate('USR-f36x-x79n9');

        $this->assertTrue($response);
    }

    public function testValidateInvalidLuhn()
    {
        $luhn = new Luhn();
        $response = $luhn->validate('USR-111-1119');

        $this->assertFalse($response);
    }
}
