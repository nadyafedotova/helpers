<?php
namespace App\Library\Loggers\Traits;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Trait HasConsoleProgressBar
 * @package App\Library\Loggers\Traits
 */
trait HasConsoleProgressBar
{
    private ProgressBar $progress_bar;
    private bool $progress_bar_quiet = true;
    private ?ConsoleOutput $console_output = null;

    private function progressBarStart(int $max = 100): void
    {
        if ($this->progress_bar_quiet) return;

        $this->console_output ??= new ConsoleOutput();
        $this->progress_bar = new ProgressBar($this->console_output, $max);
    }

    private function progress(int $value): void
    {
        if (!$this->progress_bar_quiet) {
            $this->progress_bar->setProgress($value);
        }
    }

    private function progressBarFinish(): void
    {
        if (!$this->progress_bar_quiet) {
            $this->progress_bar->finish();
            $this->console_output->writeln('');
        }
    }

    public function disableProgressBar(): void
    {
        $this->progress_bar_quiet = true;
    }

    public function enableProgressBar(): void
    {
        $this->progress_bar_quiet = false;
    }
}
