<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\RequestHandler;

use AntiMattr\Sears\Format\XMLBuilder;
use Buzz\Message\Request;
use Doctrine\Common\Collections\Collection;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
abstract class AbstractRequestHandler
{
    /** @var AntiMattr\Sears\Format\XMLBuilder */
    protected $xmlBuilder;

    public function __construct(XMLBuilder $xmlBuilder)
    {
        $this->xmlBuilder = $xmlBuilder;
    }

    /**
     * @param Buzz\Message\Request                   $request
     * @param Doctrine\Common\Collections\Collection $collection
     */
    abstract public function bindCollection(Request $request, Collection $collection);
}
