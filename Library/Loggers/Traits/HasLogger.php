<?php

namespace App\Library\Loggers\Traits;

use App\Library\Loggers\LoggerQuiet;
use Psr\Log\LoggerInterface;

/**
 * Trait HasLogger
 * @package App\Library\Loggers\Traits
 */
trait HasLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @return LoggerInterface
     */
    public function logger()
    {
        if (is_null($this->logger)) {
            $this->logger = new LoggerQuiet();
        }

        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}
