<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class OpenFileException
 * @package App\Library\UnzipGz\Exceptions
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
