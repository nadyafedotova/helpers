<?php

namespace App\Library\XMLFeedReader\Exceptions;

/**
 * Class ReadFileException
 * @package App\Library\XMLFeedReader\Exceptions
 */
class ReadFileException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct('Read file error. File: ' . $path);
    }
}
