<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/luhn
 */

namespace Luhn\Libs;

/**
 * Class AlnumBaseConverter
 *
 * @package Luhn
 */
class AlnumBaseConverter
{

    /**
     * @var string
     */
    private $numberString = "";

    /**
     * @var array
     */
    private $numberArray = [];

    /**
     * @var int
     */
    private $base = 10;

    /**
     * Sets the base for conversion.
     *
     * @param int $base
     * @return AlnumBaseConverter
     */
    public function setBase(int $base): AlnumBaseConverter
    {
        $this->base = $base;
        return $this;
    }

    /**
     * Sets an array on numbers.
     *
     * @param array $numberArray
     * @return AlnumBaseConverter
     */
    public function setNumberArray(array $numberArray): AlnumBaseConverter
    {
        $this->numberArray = $numberArray;
        return $this;
    }

    /**
     * Sets a string of numbers.
     *
     * @param string $numberString
     * @return AlnumBaseConverter
     */
    public function setNumberString(string $numberString): AlnumBaseConverter
    {
        $this->numberString = $numberString;
        return $this;
    }

    /**
     * Converts a string to a number array.
     *
     * @return array
     */
    public function stringToNumberArray(): array
    {
        $this->numberArray = [];
        for ($i = 0; $i < mb_strlen($this->numberString); $i++) {
            $this->numberArray[] = base_convert($this->numberString[$i], $this->base, 10);
        }

        return $this->numberArray;
    }

    /**
     * Converts an array to a string.
     *
     * @return string
     */
    public function numberArrayToString(): string
    {
        $this->numberString = '';
        foreach ($this->numberArray as $value) {
            $this->numberString .= base_convert($value, 10, $this->base);
        }
        return $this->numberString;
    }
}
