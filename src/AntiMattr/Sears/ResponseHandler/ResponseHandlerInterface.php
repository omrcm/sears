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

use Doctrine\Common\Collections\Collection;
use Buzz\Message\Response;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
interface ResponseHandlerInterface
{
    /**
     * @param Buzz\Message\Response                  $response
     * @param Doctrine\Common\Collections\Collection $collection
     */
    public function bindCollection(Response $response, Collection $collection);
}
