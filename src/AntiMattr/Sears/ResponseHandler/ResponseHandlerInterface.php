<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\ResponseHandler;

use AntiMattr\Sears\Model\IdentifiableInterface;
use Buzz\Message\Response;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
interface ResponseHandlerInterface
{
    /**
     * @param Buzz\Message\Response                       $response
     * @param AntiMattr\Sears\Model\IdentifiableInterface $object
     */
    public function bind(Response $response, IdentifiableInterface $object);
}
