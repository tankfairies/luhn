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
 * Interface GeneratorInterface
 *
 * @package Luhn\Generator
 */
interface GeneratorInterface
{
    public function generate(): void;
    public function setLength(int $length): void;
    public function getToken(): string;
}
