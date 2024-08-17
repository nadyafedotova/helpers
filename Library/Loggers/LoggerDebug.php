<?php

namespace App\Library\Loggers;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Psr\Log\InvalidArgumentException;

/**
 * Class LoggerDebug
 * @package App\Library\Loggers
 */
class LoggerDebug implements LoggerInterface
{
    protected ConsoleOutput $output;

    /**
     * LoggerConsole constructor.
     */
    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    /**
     * System is unusable.
     *
     * @param mixed[] $context
     */
    public function emergency(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param mixed[] $context
     */
    public function alert(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param mixed[] $context
     */
    public function critical(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param mixed[] $context
     */
    public function error(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param mixed[] $context
     */
    public function warning(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param mixed[] $context
     */
    public function notice(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param mixed[] $context
     */
    public function info(string $message, array $context = array()): void
    {
        $this->output($message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param mixed[] $context
     */
    public function debug(string $message, array $context = array()): void
    {
        $this->output($message, $context);
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
        $this->output('[' . date('Y-m-d H:i:s') . '] ' . $level . ': ' . $message, $context);
    }

    /**
     * Output formatted log.
     *
     * @param mixed[] $context
     */
    protected function output(string $message, array $context = array()): void
    {
        $this->output->writeln('[' . date('Y-m-d H:i:s') . '] ' . $message);

        if (!empty($context)) {
            $this->output->writeln(print_r($context, true));
        }
    }
}
