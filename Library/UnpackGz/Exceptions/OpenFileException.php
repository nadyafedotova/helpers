<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class OpenFileException
 * @package App\Library\UnzipGz\Exceptions
 */
class OpenFileException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct('Can\'t open file: ' . $path);
    }
}
