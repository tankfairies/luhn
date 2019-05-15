<?php
/**
 * Copyright (c) 2019 Tanklfairies
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/tankfairies/luhn
 */

namespace Luhn\Generator\Adapter;

use Luhn\Generator\AbstractGenerator;

/**
 * Class SimpleNum
 * @package Luhn\StringGenerator\Adapter
 */
class SimpleNum extends AbstractGenerator
{

    /**
     * Generates numeric token.
     */
    public function generate(): void
    {
        $token = [];
        for ($j = 0; $j < $this->charLength; $j++) {
            $token[] = mt_rand(0, 9);
        }

        $this->token = implode('', $token);
    }
}
