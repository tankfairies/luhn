<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/luhn
 */

namespace Tankfairies\Luhn\Libs;

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
    private string $numberString = "";

    /**
     * @var int
     */
    private int $base = 10;

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
        $numberArray = [];
        for ($i = 0; $i < mb_strlen($this->numberString); $i++) {
            $numberArray[] = base_convert($this->numberString[$i], $this->base, 10);
        }

        return $numberArray;
    }
}
