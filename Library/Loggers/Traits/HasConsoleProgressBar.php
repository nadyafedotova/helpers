<?php

namespace App\Library\Loggers\Traits;

use App\Library\Loggers\LoggerQuiet;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Trait HasConsoleProgressBar
 * @package App\Library\Loggers\Traits
 */
trait HasConsoleProgressBar
{
    /**
     * @var ProgressBar
     */
    private $progress_bar;

    /**
     * @var bool
     */
    private $progress_bar_quite = true;

    /**
     * @var ConsoleOutput
     */
    private $console_output = null;

    /**
     * @param int $max
     */
    private function progressBarStart($max = 100)
    {
        if ($this->progress_bar_quite) {
            return;
        }

        if (is_null($this->console_output)) {
            $this->console_output = new ConsoleOutput();
        }

        $this->progress_bar = new ProgressBar($this->console_output, $max);
    }

    /**
     * @param mixed $value
     */
    private function progress($value)
    {
        if ($this->progress_bar_quite) {
            return;
        }
        $this->progress_bar->setProgress($value);
    }

    /**
     *
     */
    private function progressBarFinish()
    {
        if ($this->progress_bar_quite) {
            return;
        }
        $this->progress_bar->finish();
        $this->console_output->writeln('');
    }

    /**
     *
     */
    public function disableProgressBar()
    {
        $this->progress_bar_quite = true;
    }

    /**
     *
     */
    public function enableProgressBar()
    {
        $this->progress_bar_quite = false;
    }
}
