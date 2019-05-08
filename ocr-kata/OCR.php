<?php

require_once 'Store.php';

class OCR
{
    const LINE_LENGTH = 27;
    const REAL_LINES_PER_LOGICAL_LINE = 4;

    function processFile($file) {
        $handle = fopen($file, 'r');
        $chrArray = [];

        $realLines = 0;
        $logicalLines = 0;

        $lineGrid = [];
        while (!feof($handle)) {
            $line = fgets($handle);
            $line = preg_replace('/\n/', '', $line);
            $realLines++;

            if ($realLines === self::REAL_LINES_PER_LOGICAL_LINE) {
                $logicalLines++;
                $realLines = 0;
                $chrArray[] = $lineGrid;
                $lineGrid = [];
                continue;
            }

            $chunked = str_split($line, 3);
            if (!count($lineGrid)) {
                $lineGrid = $chunked;
                continue;
            }
            array_walk($lineGrid, function (&$item, $index, $newArray) {
                $item .= $newArray[$index];
            }, $chunked);
        }

        return $this->transcribe($chrArray);
    }

    function transcribe($content) {
        array_walk($content, function (&$number) {
            $number = $this->decode($number);
        });
        return $content;
    }

    function decode(array $xters) {
        $str = '';
        while ($xter = array_shift($xters)) {
            if (isset(Store::DICT[$xter])) {
                $str .= Store::DICT[$xter];
            }
        }
        return $str;
    }

}