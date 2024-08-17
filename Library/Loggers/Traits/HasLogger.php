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
    private LoggerInterface $logger;

    public function logger(): LoggerQuiet|LoggerInterface
    {
        return $this->logger ??= new LoggerQuiet();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
