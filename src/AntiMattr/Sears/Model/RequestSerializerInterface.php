<?php

/*
 * This file is part of the AntiMattr Sears Library, a library by Matthew Fitzgerald.
 *
 * (c) 2014 Matthew Fitzgerald
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AntiMattr\Sears\Model;

/**
 * @author Matthew Fitzgerald <matthewfitz@gmail.com>
 */
interface RequestSerializerInterface
{
    /**
     * @return array
     */
    public function toArray();
}
