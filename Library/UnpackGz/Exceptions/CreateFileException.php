<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class CreateFileException
 * @package App\Library\UnzipGz\Exceptions
 */
class CreateFileException extends \Exception
{
    public function __construct(string $file_path)
    {
        parent::__construct('Can\'t create file or directory: ' . $file_path);
    }
}
