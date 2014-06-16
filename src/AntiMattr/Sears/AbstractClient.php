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
abstract class AbstractClient
{
    /** @var Psr\Log\LoggerInterface */
    protected $logger;

    /**
     * @param  string                                      $status
     * @return Doctrine\Common\Collections\ArrayCollection $collection
     */
    abstract public function findPurchaseOrdersByStatus($status);

    /**
     * @param string $message
     * @param mixed  $pattern
     * @param mixed  $replacement
     */
    protected function log(&$message, $pattern = array('/email=(.*[^&])&password=(.*[^&])&/'), $replacement = array('email=xxxxxx&password=yyyyyy&'))
    {
        if (null !== $this->logger) {

            if (null !== $pattern && null !== $replacement) {
                $message = preg_replace($pattern, $replacement, $message);
            }

            $this->logger->debug($message);
        }
    }
}
