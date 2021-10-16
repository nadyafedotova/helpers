<?php

namespace App\Library\ChunkDownloadFile\Exceptions;

/**
 * Class OpenUrlException
 * @package App\Library\ChunkDownloadFile\Exceptions
 */
class OpenUrlException extends \Exception
{
    /**
     * OpenUrlException constructor.
     *
     * @param string $url
     */
    public function __construct($url)
    {
        parent::__construct('Can\'t open url: ' . $url);
    }
}
