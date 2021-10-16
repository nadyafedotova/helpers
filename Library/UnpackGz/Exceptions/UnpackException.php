<?php

namespace App\Library\UnzipGz\Exceptions;

/**
 * Class UnpackException
 * @package App\Library\UnzipGz\Exceptions
 */
class UnpackException extends \Exception
{
    /**
     * UnpackException constructor.
     *
     * @param string $path
     * @param string $extract_path
     */
    public function __construct($path, $extract_path)
    {
        parent::__construct('Unpack file error. File: ' . $path . ' Extract path: ' . $extract_path);
    }
}
