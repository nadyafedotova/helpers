<?php

namespace App\Library\XMLFeedReader\Exceptions;

/**
 * Class OpenFileException
 * @package App\Library\XMLFeedReader\Exceptions
 */
class OpenFileException extends \Exception
{
    /**
     * OpenFileException constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct('Can\'t open file: ' . $path);
    }
}
