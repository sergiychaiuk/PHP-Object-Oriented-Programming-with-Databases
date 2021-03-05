<?php

class ParseCSV {

    public static $delimiter = ',';

    private $filename;
    private $header;
    private $date = [];
    private $row_count = 0;

    public function __construct($filename = '') {
        if ($filename != '') {
            $this->file($filename);
        }
    }

    public function file($filename) {
        if (!file_exists($filename)) {
            echo 'File does not exist.';
            return false;
        } elseif (!is_readable($filename)) {
            echo 'File is not readable.';
            return false;
        }
        $this->filename = $filename;
        return true;
    }

    public function parse() {
        if (!isset($this->filename)) {
            echo 'File not set.';
            return false;
        }

        $this->reset();

        $file = fopen($this->filename, 'r');
        while (!feof($file)) {
            $row = fgetcsv($file, 0, self::$delimiter);
            if ($row == [NULL] || $row === false) { continue; }
            if (!$this->header) {
                $this->header = $row;
            } else {
                $this->date[] = array_combine($this->header, $row);
                $this->row_count++;
            }
        }
        fclose($file);
        return $this->date;
    }

    public function last_results() {
        return $this->date;
    }

    public function row_count() {
        return $this->row_count;
    }

    private function reset() {
        $this->header = NULL;
        $this->date = [];
        $this->row_count = 0;
    }

}