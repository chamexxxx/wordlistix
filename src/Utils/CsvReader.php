<?php

namespace App\Utils;

use SplFileObject;

class CsvReader implements \Iterator
{
    /**
     * @var SplFileObject
     */
    private $file;

    private $position = 0;

    private $header = [];

    private $lines = [];

    public function __construct(string $filename, string $separator)
    {
        $this->file = new SplFileObject($filename);

        $this->file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::READ_AHEAD |
            SplFileObject::DROP_NEW_LINE
        );

        $this->file->setCsvControl($separator);

        $this->position = 0;

        $this->header = $this->file->fgetcsv();
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function current()
    {
        return $this->lines[$this->position];
    }

    public function next()
    {
        $this->addLine();
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->lines[$this->position]);
    }

    public function rewind()
    {
        $this->addLine();
        $this->position = 0;
    }

    private function addLine() {
        $line = $this->fgetcsv();
        
        if ($line) {
            $this->lines[] = $line;
        }
    }
    
    private function fgetcsv()
    {
        $line = $this->file->fgetcsv();
        
        if ($this->file->eof() || $line === false) {
            return false;
        }
        
        return array_combine($this->header, $line);
    }
}
