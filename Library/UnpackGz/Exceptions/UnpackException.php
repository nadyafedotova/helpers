<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class UnpackException
 * @package App\Library\UnzipGz\Exceptions
 */
class UnpackException extends \Exception
{
    public function __construct(string $path, string $extract_path)
    {
        parent::__construct('Unpack file error. File: ' . $path . ' Extract path: ' . $extract_path);
    }
}
