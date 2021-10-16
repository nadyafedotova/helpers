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
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $extract_path;

    /**
     * Progress callback. Args: $percent, $extracted_bytes, $estimate_size.
     *
     * @var callable
     */
    protected $progress;

    /**
     * @var int
     */
    protected $estimate_size = -1;

    /**
     * @var int
     */
    protected $current_progress = 0;

    /**
     * Unpack constructor.
     *
     * @param string $path
     * @param string $extract_path
     */
    public function __construct($path, $extract_path)
    {
        $this->path = $path;
        $this->extract_path = $extract_path;
    }

    /**
     * @throws CreateFileException
     * @throws OpenFileException
     * @throws UnpackException
     */
    public function run()
    {
        $this->createDirectoryIfNotExists();
        $this->fetchEstimateSize();

        $buffer_size = 4096;
        $file = gzopen($this->path, 'rb');
        if ($file === false) {
            throw new OpenFileException($this->path);
        }
        $extract_file = fopen($this->extract_path, 'wb');
        if ($extract_file === false) {
            throw new CreateFileException($this->path);
        }
        $extracted_bytes = 0;
        while (!gzeof($file)) {
            $written_bytes = fwrite($extract_file, gzread($file, $buffer_size));
            if ($written_bytes === false) {
                throw new UnpackException($this->path, $this->extract_path);
            }
            $extracted_bytes += $written_bytes;

            if ($this->progress) {
                $percent = ceil($extracted_bytes / $this->estimate_size * 100);
                if ($percent > 100) {
                    $percent = 100;
                }
                if ($percent != $this->current_progress) {
                    call_user_func_array($this->progress, [$percent, $extracted_bytes, $this->estimate_size]);
                }
                $this->current_progress = $percent;
            }
        }
        fclose($extract_file);
        gzclose($file);
    }

    /**
     * Progress callbacks.
     *
     * @param string $progress Progress callback. Args: $percent, $extracted_bytes, $estimate_size.
     */
    public function progress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return bool
     *
     * @throws CreateFileException
     */
    protected function createDirectoryIfNotExists()
    {
        $directory = $this->getExtractPathDirectory();
        if (!File::isDirectory($directory)) {

            if (!File::makeDirectory($directory, 0755, true)) {
                throw new CreateFileException($directory);
            }
        }
        return true;
    }

    /**
     * @return string
     */
    protected function getExtractPathDirectory()
    {
        return dirname($this->extract_path);
    }

    /**
     * @return int
     */
    protected function fetchEstimateSize()
    {
        $this->estimate_size = File::size($this->path) * 7;
        return $this->estimate_size;
    }
}
