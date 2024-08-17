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
     * Progress callback. Args: $percent, $processed_bytes, $file_size.
     *
     * @var callable
     */
    protected $progress = null;

    /**
     * Progress callback. Args: $node.
     *
     * @var callable
     */
    protected $process_node = null;
    protected int $file_size = -1;
    protected int $current_progress = 0;

    public function __construct(
        protected string $path,
        protected string $node_name
    )
    {
    }

    /**
     * @throws OpenFileException
     * @throws ReadFileException
     */
    public function run(): void
    {
        $this->file_size = $this->fetchFileSize();

        $reader = new XMLReader();
        if (!$reader->open($this->path)) {
            throw new OpenFileException($this->path);
        }

        $processed_bytes = 0;
        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::ELEMENT && $reader->name === $this->node_name) {
                $node_xml = $reader->readOuterXML();
                $processed_bytes += strlen($node_xml);

                $node_object = $this->parseNode($node_xml);
                $this->processNodeCallback($node_object);
                $this->updateProgress($processed_bytes);
            }
        }

        $reader->close();
    }

    /**
     * Progress callbacks.
     *
     * @param callable $progress Progress callback. Args: $percent, $count, $processed_bytes, $file_size.
     */
    public function progress(callable $progress): void
    {
        $this->progress = $progress;
    }

    /**
     * Process node callbacks.
     *
     * @param callable $process_node Progress callback. Args: $node.
     */
    public function processNode(callable $process_node): void
    {
        $this->process_node = $process_node;
    }

    protected function fetchFileSize(): int
    {
        return $this->file_size = File::size($this->path);
    }

    /**
     * @throws ReadFileException
     */
    protected function parseNode(string $node_xml): object
    {
        return (object)simplexml_load_string($node_xml, 'SimpleXMLElement', LIBXML_NOCDATA)
            ?: throw new ReadFileException($this->path);
    }


    protected function processNodeCallback(object $node_object): void
    {
        $this->process_node && call_user_func($this->process_node, $node_object);
    }

    protected function updateProgress(int $processed_bytes): void
    {
        if ($this->progress && $this->file_size > 0) {
            $percent = min(100, ceil($processed_bytes / $this->file_size * 100));
            if ($percent !== $this->current_progress) {
                call_user_func($this->progress, $percent, $processed_bytes, $this->file_size);
                $this->current_progress = $percent;
            }
        }
    }
}
