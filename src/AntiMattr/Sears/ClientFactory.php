<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
class ClientFactory
{
    /**
     * The Client instances.
     *
     * @var array
     */
    private $clients = array();    

    /** @var AntiMattr\Sears\Client */
    private $realClient;

    /** @var AntiMattr\Sears\FakeResponseClient */
    private $fakeResponseClient;

    public function __construct(Client $realClient, FakeResponseClient $fakeResponseClient)
    {
        $this->realClient = $realClient;
        $this->fakeResponseClient = $fakeResponseClient;
    }

    /**
     * @param  string                         $alias
     * @param  classname                      $classname
     * @return AntiMattr\Sears\AbstractClient
     */
    public function getClient($alias, $classname)
    {

        if (isset($this->clients[$alias])) {
            return $this->clients[$alias];
        }

        if ('AntiMattr\Sears\FakeResponseClient' === $classname) {
            $client = clone $this->fakeResponseClient;
        } else {
            $client = clone $this->realClient;
        }

        $this->clients[$alias] = $client;
        return $client;
    }
}