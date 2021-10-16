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
    /**
     * Chunk size in MB.
     *
     * @var int
     */
    protected $chunk_size = 25;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $save_path;

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

    /**
     * @var int
     */
    protected $file_size = -1;

    /**
     * @var int
     */
    protected $current_progress = 0;

    /**
     * DownloadFile constructor.
     *
     * @param string $url
     * @param string $save_path
     */
    public function __construct($url, $save_path)
    {
        $this->url = $url;
        $this->save_path = $save_path;
    }

    /**
     * Run file download.
     *
     * @return int
     *
     * @throws CreateFileException
     * @throws DownloadException
     * @throws OpenUrlException
     */
    public function run()
    {
        $this->createDirectoryIfNotExists();

        $this->fetchFileSize();

        if ($this->progress_not_available && $this->file_size < 0) {
            call_user_func($this->progress_not_available);
        }

        $chunk_size = $this->getChunkSizeInBytes();
        $downloaded_bytes = 0;

        $remote_file_handler = fopen($this->url, 'rb');

        if ($remote_file_handler === false) {
            throw new OpenUrlException($this->url);
        }

        $save_file_handler = fopen($this->save_path, 'w+');
        if ($save_file_handler === false) {
            throw new CreateFileException($this->save_path);
        }

        while (!feof($remote_file_handler)) {
            $data = fread($remote_file_handler, $chunk_size);
            if ($data === false) {
                throw new DownloadException($this->url, $this->save_path);
            }

            if (fwrite($save_file_handler, $data, strlen($data)) === false) {
                throw new DownloadException($this->url, $this->save_path);
            }

            $downloaded_bytes += strlen($data);

            if ($this->progress && $this->file_size >= 0) {
                $percent = ceil($downloaded_bytes / $this->file_size * 100);

                if ($percent != $this->current_progress) {
                    call_user_func_array($this->progress, [$percent, $downloaded_bytes, $this->file_size]);
                }
                $this->current_progress = $percent;
            }
        }
        fclose($remote_file_handler);

        fclose($save_file_handler);

        return $downloaded_bytes;
    }

    /**
     * Progress callbacks.
     *
     * @param string $progress Progress callback. Args: $percent, $downloaded_bytes, $file_size.
     * @param string $progress_not_available
     */
    public function progress($progress, $progress_not_available)
    {
        $this->progress = $progress;
        $this->progress_not_available = $progress_not_available;
    }

    /**
     * @param int $chunk_size Chunk size in MB.
     */
    public function setChunkSize($chunk_size)
    {
        $this->chunk_size = $chunk_size;
    }

    /**
     * @return string
     */
    protected function getSavePathDirectory()
    {
        return dirname($this->save_path);
    }

    /**
     * @return int
     */
    protected function getChunkSizeInBytes()
    {
        return $this->chunk_size * 1024 * 1024;
    }

    /**
     * @return int
     */
    protected function fetchFileSize()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $data = curl_exec($curl);

        if ($data === false) {
            return -1;
        }

        if (preg_match('/Content-Length: (\d+)/i', $data, $matches)) {
            $content_length = (int)$matches[1];
            $this->file_size = $content_length;
            return $this->file_size;
        }
        return -1;
    }

    /**
     * @return bool
     *
     * @throws CreateFileException
     */
    protected function createDirectoryIfNotExists()
    {
        $directory = $this->getSavePathDirectory();
        if (!File::isDirectory($directory)) {

            if (!File::makeDirectory($directory, 0755, true)) {
                throw new CreateFileException($directory);
            }
        }
        return true;
    }
}
