<?php

namespace App\Library\XMLFeedReader\Exceptions;

/**
 * Class ReadFileException
 * @package App\Library\XMLFeedReader\Exceptions
 */
class ReadFileException extends \Exception
{
    /**
     * ReadFileException constructor.
     *
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct('Read file error. File: ' . $path);
    }
}
