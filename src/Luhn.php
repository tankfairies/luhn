<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/luhn
 */

namespace Tankfairies\Luhn;

use Tankfairies\Luhn\Generator\GeneratorInterface;
use Tankfairies\Luhn\Libs\AlnumBaseConverter;
use Tankfairies\Luhn\Libs\LuhnException;

/**
 * Class Luhn
 *
 * Generates or validates a luhn value.
 *
 * @package Luhn
 */
class Luhn
{
    /**
     * @var GeneratorInterface|null
     */
    private GeneratorInterface|null $generator;

    /**
     * @var int
     */
    private int $stringLength = 0;

    /**
     * @var array
     */
    private array $format = [];

    /**
     * @var int
     */
    private int $base = 10;

    /**
     * @var array
     */
    private array $numberArray = [];

    /**
     * @var int
     */
    private int $luhnValue = 0;

    public function __construct(GeneratorInterface $generator = null)
    {
        $this->generator = $generator;
    }

    /**
     * Defines the template of the luhn to be generated.
     *
     * @param string $template
     * @return Luhn
     * @throws LuhnException
     */
    public function setTemplate(string $template): Luhn
    {
        $this->stringLength = mb_strlen(preg_replace("/[^#]/", '', $template));

        if ($this->stringLength < 2) {
            throw new LuhnException('Template must contain at least 2 # substitutes.');
        }

        $this->format = str_split($template);

        return $this;
    }

    /**
     * Generates and returns a luhn.
     *
     * @return string
     * @throws LuhnException
     */
    public function generate(): string
    {
        $this->generatorValidation();

        $this->generator->setLength($this->stringLength);
        $this->generator->generate();

        $token = $this->buildToken();

        $token .= $this->setNumberArray($this->numberArray($token))->getChecksum();

        return $token;
    }

    /**
     * Validates a token returning true or false.
     *
     * @param string $token
     * @return bool
     */
    public function validate(string $token): bool
    {
        $string = $this->numberArray($token);
        return $this->setNumberArray($string)->isValid();
    }

    /**
     * @throws LuhnException
     */
    public function generatorValidation(): void
    {
        if ($this->stringLength < 2 || empty($this->format)) {
            throw new LuhnException('Template not set');
        }

        if (!($this->generator instanceof GeneratorInterface)) {
            throw new LuhnException('Generator not set');
        }
    }

    private function buildToken(): string
    {
        $this->generator->setLength($this->stringLength);
        $this->generator->generate();

        $token = $this->generator->getToken();

        $i = 0;
        $result = '';

        $tokenCharCount = substr_count(implode('', $this->format), '#')-1;

        foreach ($this->format as $chr) {
            if ($chr !== '#') {
                $result .= $chr;
                continue;
            }

            if ($i == $tokenCharCount) {
                break;
            }

            $result .= $token[$i];
            $i++;
        }

        return $result;
    }

    /**
     * @param string $string
     * @return array
     */
    private function numberArray(string $string): array
    {
        $alnumBaseConverter = new AlnumBaseConverter();
        $alnumBaseConverter->setBase(36);

        return $alnumBaseConverter
            ->setNumberString(preg_replace("/![^A-Za-z0-9]/", '', $string))
            ->stringToNumberArray();
    }

    /**
     * @param array $numberArray
     * @return Luhn
     */
    private function setNumberArray(array $numberArray): Luhn
    {
        $this->numberArray = $numberArray;
        return $this;
    }

    /**
     * Returns the luhn checksum
     *
     * @return int
     */
    private function getChecksum(): int
    {
        $this->generateChecksum(true);
        return ((($this->base) - ($this->luhnValue % $this->base)) % $this->base);
    }

    /**
     * Verifies if token is valid
     *
     * @return bool
     */
    private function isValid(): bool
    {
        $this->generateChecksum();
        return (($this->luhnValue % $this->base == 0) && ($this->luhnValue != 0));
    }

    /**
     * Generates the checksum for a luhn
     *
     * @param bool $excluding
     */
    private function generateChecksum(bool $excluding = false): void
    {
        $sum = 0;
        $reverse = array_reverse($this->numberArray);
        $length = count($reverse);

        $i = 1;
        if ($excluding === true) {
            $res  = $reverse[0] * 2;
            if ($res >= $this->base) {
                $res -= ($this->base - 1);
            }
            $sum += $res;
            $i++;
        }

        for (; $i < $length; $i += 2) {
            $res = $reverse[$i] * 2;
            if ($res >= $this->base) {
                $res -= ($this->base - 1);
            }
            $sum += $res;

            $res = $reverse[$i - 1];
            if ($res >= $this->base) {
                $res -= ($this->base - 1);
            }
            $sum += $res;
        }

        if ($i === $length) {
            $res = $reverse[$i - 1];
            $sum += $res;
        }

        $this->luhnValue = $sum;
    }
}
