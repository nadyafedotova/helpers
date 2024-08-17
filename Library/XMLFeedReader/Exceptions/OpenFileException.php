<?php

namespace App\Library\XMLFeedReader\Exceptions;

/**
 * Class OpenFileException
 * @package App\Library\XMLFeedReader\Exceptions
 */
class OpenFileException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct('Can\'t open file: ' . $path);
    }
}
