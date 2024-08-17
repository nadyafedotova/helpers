<?php

namespace App\Library\ChunkDownloadFile\Exceptions;

/**
 * Class OpenUrlException
 * @package App\Library\ChunkDownloadFile\Exceptions
 */
class OpenUrlException extends \Exception
{
    public function __construct(string $url)
    {
        parent::__construct('Can\'t open url: ' . $url);
    }
}
