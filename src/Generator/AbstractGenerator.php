<?php
/**
 * Copyright (c) 2019 Tankfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/luhn
 */

namespace Tankfairies\Luhn\Generator;

/**
 * Class AbstractGenerator
 * @package Luhn\Generator
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected string $token = '';

    /**
     * @var int
     */
    protected int $charLength;

    /**
     * Sets the number of characters to be generated.
     *
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->charLength = $length-1;
    }

    /**
     * Returns the generated token.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
