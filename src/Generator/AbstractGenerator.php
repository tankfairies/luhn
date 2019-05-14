<?php

namespace Luhn\Generator;

/**
 * Class AbstractGenerator
 * @package Luhn\Generator
 */
abstract class AbstractGenerator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected $token = '';

    /**
     * @var int
     */
    protected $charLength = 5;

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->charLength = $length;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
