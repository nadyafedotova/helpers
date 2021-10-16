<?php

namespace App\Library\ChunkDownloadFile\Exceptions;

/**
 * Class DownloadException
 * @package App\Library\ChunkDownloadFile\Exceptions
 */
class DownloadException extends \Exception
{
    /**
     * DownloadException constructor.
     *
     * @param string $url
     * @param string $file_path
     */
    public function __construct($url, $file_path)
    {
        parent::__construct('Download file error. Url: ' . $url . ' Save Path: ' . $file_path);
    }
}
