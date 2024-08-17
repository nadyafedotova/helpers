<?php

namespace App\Library\ChunkDownloadFile\Exceptions;

/**
 * Class DownloadException
 * @package App\Library\ChunkDownloadFile\Exceptions
 */
class DownloadException extends \Exception
{
    public function __construct(string $url, string $file_path)
    {
        parent::__construct('Download file error. Url: ' . $url . ' Save Path: ' . $file_path);
    }
}
