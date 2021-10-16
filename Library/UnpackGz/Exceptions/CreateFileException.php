<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class CreateFileException
 * @package App\Library\UnzipGz\Exceptions
 */
class CreateFileException extends \Exception
{
    /**
     * CreateFileException constructor.
     *
     * @param string $file_path
     */
    public function __construct($file_path)
    {
        parent::__construct('Can\'t create file or directory: ' . $file_path);
    }
}
