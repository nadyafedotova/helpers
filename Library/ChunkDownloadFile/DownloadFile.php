<?php

namespace App\Library\ChunkDownloadFile;

use App\Library\ChunkDownloadFile\Exceptions\CreateFileException;
use App\Library\ChunkDownloadFile\Exceptions\DownloadException;
use App\Library\ChunkDownloadFile\Exceptions\OpenUrlException;
use Illuminate\Support\Facades\File;

/**
 * Class DownloadFile
 * @package App\Library\ChunkDownloadFile
 */
class DownloadFile
{
    protected int $chunk_size = 25 * 1024 * 1024;

    /**
     * Progress callback. Args: $percent, $downloaded_bytes, $file_size.
     *
     * @var callable
     */
    protected $progress;

    /**
     * @var callable
     */
    protected $progress_not_available;
    protected int $file_size = -1;
    protected int $current_progress = 0;

    public function __construct(
        protected string $url,
        protected string $save_path
    )
    {
    }

    /**
     * @throws OpenUrlException
     * @throws CreateFileException
     * @throws DownloadException
     */
    public function run(): int
    {
        $this->createDirectoryIfNotExists();

        if (($this->file_size = $this->fetchFileSize()) < 0 && $this->progress_not_available) {
            call_user_func($this->progress_not_available);
        }

        return $this->downloadFile();
    }

    public function progress(callable $progress, callable $progress_not_available): void
    {
        $this->progress = $progress;
        $this->progress_not_available = $progress_not_available;
    }

    public function setChunkSize(int $megabytes): void
    {
        $this->chunk_size = $megabytes * 1024 * 1024;
    }

    /**
     * @throws DownloadException
     * @throws CreateFileException
     * @throws OpenUrlException
     */
    protected function downloadFile(): int
    {
        $downloaded_bytes = 0;

        $remote_file_handler = fopen($this->url, 'rb') ?: throw new OpenUrlException($this->url);
        $save_file_handler = fopen($this->save_path, 'w+') ?: throw new CreateFileException($this->save_path);

        while ($data = fread($remote_file_handler, $this->chunk_size)) {
            if (fwrite($save_file_handler, $data) === false) {
                throw new DownloadException($this->url, $this->save_path);
            }
            $downloaded_bytes += strlen($data);
            $this->reportProgress($downloaded_bytes);
        }

        fclose($remote_file_handler);
        fclose($save_file_handler);

        return $downloaded_bytes;
    }

    protected function reportProgress(int $downloaded_bytes): void
    {
        if ($this->progress && $this->file_size > 0) {
            $percent = ceil($downloaded_bytes / $this->file_size * 100);
            if ($percent != $this->current_progress) {
                call_user_func($this->progress, $percent, $downloaded_bytes, $this->file_size);
                $this->current_progress = $percent;
            }
        }
    }

    protected function fetchFileSize(): int
    {
        $curl = curl_init($this->url);
        curl_setopt_array($curl, [
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $data = curl_exec($curl);
        curl_close($curl);

        return $data && preg_match('/Content-Length: (\d+)/i', $data, $matches)
            ? (int)$matches[1]
            : -1;
    }

    /**
     * @throws CreateFileException
     */
    protected function createDirectoryIfNotExists(): void
    {
        $directory = dirname($this->save_path);
        if (!File::isDirectory($directory) && !File::makeDirectory($directory, 0755, true)) {
            throw new CreateFileException($directory);
        }
    }
}