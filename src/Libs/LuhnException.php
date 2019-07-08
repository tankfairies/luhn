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

use Exception;

/**
 * Class LuhnException
 *
 * @package Luhn
 */
class LuhnException extends Exception
{

    /**
     * LuhnException constructor.
     *
     * @param $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }
}
