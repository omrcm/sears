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

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class BadRequestException extends AbstractHttpException
{
    private $statusCode;

    /**
     * Constructor.
     *
     * @param string     $message
     * @param \Exception $previous The previous exception
     * @param integer    $code     The internal exception code
     */
    public function __construct($message = '', \Exception $previous = null, $code = 0)
    {
        parent::__construct(400, $message, $previous, $code);
    }
}
