<?php

namespace App\Library\UnpackGz;

use App\Library\UnzipGz\Exceptions\OpenFileException;
use App\Library\UnzipGz\Exceptions\UnpackException;
use App\Library\UnzipGz\Exceptions\CreateFileException;
use Illuminate\Support\Facades\File;

/**
 * Class Unpack
 * @package App\Library\UnpackGz
 */
class Unpack
{
    /**
     * Progress callback. Args: $percent, $extracted_bytes, $estimate_size.
     *
     * @var callable
     */
    protected $progress = null;
    protected int $estimate_size = -1;
    protected int $current_progress = 0;

    public function __construct(
        protected string $path,
        protected string $extract_path
    )
    {
    }

    /**
     * @throws CreateFileException
     * @throws OpenFileException
     * @throws UnpackException
     */
    public function run(): void
    {
        $this->createDirectoryIfNotExists();
        $this->estimate_size = $this->fetchEstimateSize();

        $buffer_size = 4096;
        $file = gzopen($this->path, 'rb') ?: throw new OpenFileException($this->path);
        $extract_file = fopen($this->extract_path, 'wb') ?: throw new CreateFileException($this->extract_path);

        $extracted_bytes = 0;
        while (!gzeof($file)) {
            $written_bytes = fwrite($extract_file, gzread($file, $buffer_size)) ?: throw new UnpackException($this->path, $this->extract_path);
            $extracted_bytes += $written_bytes;

            $this->updateProgress($extracted_bytes);
        }

        fclose($extract_file);
        gzclose($file);
    }

    public function progress(callable $progress): void
    {
        $this->progress = $progress;
    }

    protected function createDirectoryIfNotExists(): void
    {
        $directory = dirname($this->extract_path);
        if (!File::isDirectory($directory) && !File::makeDirectory($directory, 0755, true)) {
            throw new CreateFileException($directory);
        }
    }

    protected function fetchEstimateSize(): int
    {
        return File::size($this->path) * 7;
    }

    protected function updateProgress(int $extracted_bytes): void
    {
        if ($this->progress && $this->estimate_size > 0) {
            $percent = min(100, ceil($extracted_bytes / $this->estimate_size * 100));
            if ($percent !== $this->current_progress) {
                call_user_func($this->progress, $percent, $extracted_bytes, $this->estimate_size);
                $this->current_progress = $percent;
            }
        }
    }
}
