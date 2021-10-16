<?php

namespace App\Library\XMLFeedReader;

use App\Library\XMLFeedReader\Exceptions\OpenFileException;
use App\Library\XMLFeedReader\Exceptions\ReadFileException;
use Illuminate\Support\Facades\File;
use XMLReader;

/**
 * Class Unpack
 * @package App\Library\UnpackGz
 */
class Reader
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $node_name;

    /**
     * Progress callback. Args: $percent, $processed_bytes, $file_size.
     *
     * @var callable
     */
    protected $progress;

    /**
     * Progress callback. Args: $node.
     *
     * @var callable
     */
    protected $process_node;

    /**
     * @var int
     */
    protected $file_size = -1;

    /**
     * @var int
     */
    protected $current_progress = 0;

    /**
     * Unpack constructor.
     *
     * @param string $path
     * @param string $node_name
     */
    public function __construct($path, $node_name)
    {
        $this->path = $path;
        $this->node_name = $node_name;
    }

    /**
     * @throws OpenFileException
     * @throws ReadFileException
     */
    public function run()
    {
        $this->fetchFileSize();

        $reader = new XMLReader();

        if (!$reader->open($this->path)) {
            throw new OpenFileException($this->path);
        }

        $count = 0;

        $processed_bytes = 0;
        while ($reader->read()) {
            if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == $this->node_name) {
                $count++;

                $node_xml = $reader->readOuterXML();
                $processed_bytes += strlen($node_xml);

                $node_object = simplexml_load_string($node_xml, 'SimpleXMLElement', LIBXML_NOCDATA);
                if ($node_object === false) {
                    throw new ReadFileException($this->path);
                }

                $node_object = (object)(array)$node_object;

                if ($this->process_node) {
                    call_user_func_array($this->process_node, [$node_object]);
                }

                if ($this->progress && $this->file_size >= 0) {
                    $percent = ceil($processed_bytes / $this->file_size * 100);
                    if ($percent > 100) {
                        $percent = 100;
                    }
                    if ($percent != $this->current_progress) {
                        call_user_func_array($this->progress, [$percent, $count, $processed_bytes, $this->file_size]);
                    }
                    $this->current_progress = $percent;
                }
            }
        }
        $reader->close();
    }

    /**
     * Progress callbacks.
     *
     * @param string $progress Progress callback. Args: $percent, $count, $processed_bytes, $file_size.
     */
    public function progress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * Process node callbacks.
     *
     * @param string $process_node Progress callback. Args: $node.
     */
    public function processNode($process_node)
    {
        $this->process_node = $process_node;
    }

    /**
     * @return int
     */
    protected function fetchFileSize()
    {
        $this->file_size = File::size($this->path);
        return $this->file_size;
    }
}
