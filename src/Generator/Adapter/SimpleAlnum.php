<?php

namespace Luhn\Generator\Adapter;

use Luhn\Generator\AbstractGenerator;

/**
 * Class SimpleAlnum
 * @package Luhn\StringGenerator\Adapter
 */
class SimpleAlnum extends AbstractGenerator
{
    /**
     * @var null
     */
    private $pattern = null;

    /**
     * @var array
     */
    private $charCode = [0 => 'L', 1 => 'N'];

    /**
     * @var int
     */
    private $charCount = 2;

    /**
     * ignored the following letters i,l,o,s
     *
     * @var array
     */
    private $validLetters = ['a','b','c','d','e','f','g','h','j','k','m','n','p','q','r','t','u','v','w','x','y','z'];

    /**
     * Generates alpha numeric token.
     */
    public function generate(): void
    {
        $this->token = implode('', $this->randomPattern()->buildToken());
    }

    /**
     * Need to end with a letter and we don't know how many Number|Letter blocks it will have so we
     * start with a single letter and build from there. We then reverse the sequence.
     *
     * e.g. length six will generate
     *
     * LNNLLN -> reverse NLLNNL, later when adding luhn the sequence will be NLLNNLA
     *
     * where    N - Number
     *          L - Letter
     *
     * this will ensure that once a Luhn based check sum is appended there are never more than 2 letters or
     * numbers in a row
     *
     * @return $this
     */
    private function randomPattern(): SimpleAlnum
    {
        // setup the codes lookup
        $charIndex = 0;

        // initalise the sequencePattern and length;
        $length = 1;
        $this->pattern = [];

        // hard code first single letter;
        $this->pattern[] = $this->charCode[$charIndex];
        $charIndex = ($charIndex + 1) % $this->charCount;

        while ($length < $this->charLength) {
            // the choice is either 1 or 2, whilst N and L alternate
            $segmentLength = rand() % 2 + 1;
            while ($segmentLength > 0 && $length < $this->charLength) {
                $this->pattern[] = $this->charCode[$charIndex];
                $segmentLength--;
                $length += 1;
            }
            $charIndex = ($charIndex + 1) % $this->charCount;
        }

        $this->pattern = array_reverse($this->pattern);

        return $this;
    }

    /**
     * Converts template into token.
     *
     * @return array
     */
    private function buildToken(): array
    {
        $token = [];

        foreach ($this->pattern as $symbolType) {
            switch ($symbolType) {
                case 'N':
                    $token[] = rand(0, 9);
                    break;
                case 'L':
                    $token[] = $this->validLetters[rand(0, 21)];
                    break;
            }
        }
        return $token;
    }
}
