<?php

namespace App\Library\Loggers;

use Psr\Log\LoggerInterface;
use Psr\Log\InvalidArgumentException;

/**
 * Class LoggerQuiet
 * @package App\Library\Loggers
 */
class LoggerQuiet implements LoggerInterface
{

    /**
     * System is unusable.
     *
     * @param mixed[] $context
     */
    public function emergency(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param mixed[] $context
     */
    public function critical($message, array $context = array()): void
    {
        return;
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param mixed[] $context
     */
    public function error(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Exceptional occurrences that are not errors.
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param mixed[] $context
     */
    public function warning(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Normal but significant events.
     *
     * @param mixed[] $context
     */
    public function notice(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Interesting events.
     * Example: User logs in, SQL logs.
     *
     * @param mixed[] $context
     */
    public function info(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Detailed debug information.
     *
     * @param mixed[] $context
     */
    public function debug(string $message, array $context = array()): void
    {
        return;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed[] $context
     *
     * @throws InvalidArgumentException
     */
    public function log(mixed $level, string $message, array $context = array()): void
    {
        return;
    }
}
