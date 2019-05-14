<?php

namespace Luhn\Libs;

/**
 * Class AlnumBaseConverter
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
     * @param int $base
     * @return AlnumBaseConverter
     */
    public function setBase(int $base): AlnumBaseConverter
    {
        $this->base = $base;
        return $this;
    }

    /**
     * @param array $numberArray
     * @return AlnumBaseConverter
     */
    public function setNumberArray(array $numberArray): AlnumBaseConverter
    {
        $this->numberArray = $numberArray;
        return $this;
    }

    /**
     * @param string $numberString
     * @return AlnumBaseConverter
     */
    public function setNumberString(string $numberString): AlnumBaseConverter
    {
        $this->numberString = $numberString;
        return $this;
    }

    /**
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
