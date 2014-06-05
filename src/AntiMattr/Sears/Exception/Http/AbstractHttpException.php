<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\Exception\Http;

use AntiMattr\Sears\Exception\IntegrationException;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
abstract class AbstractHttpException extends IntegrationException implements ExceptionInterface
{
    private $statusCode;

    public function __construct(
        $statusCode,
        $message,
        \Exception $previous = null,
        $code = 0)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
