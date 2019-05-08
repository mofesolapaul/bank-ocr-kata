<?php
/**
 * Created by PhpStorm.
 * User: mb-pro-home
 * Date: 2019-05-07
 * Time: 17:19
 */

require_once 'OCR.php';

use PHPUnit\Framework\TestCase;

class OCRTest extends TestCase
{
    const PATH = 'data/';
    private $ocr;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        $this->ocr = new OCR();
        parent::__construct($name, $data, $dataName);
    }

    private function makeFile($fileNum = 1) {
        $file = sprintf('%socr-%d.txt', self::PATH, $fileNum);
        return $file;
    }

    function testFilePath() {
        $this->assertEquals('data/ocr-1.txt', $this->makeFile(1));
    }

    function testFile1() {
        $file1 = $this->makeFile(1);
        $this->assertEquals(['123456789'], $this->ocr->processFile($file1));
    }

    function testFile2() {
        $file2 = $this->makeFile(2);
        $this->assertEquals(['490067715'], $this->ocr->processFile($file2));
    }

    function testFile3() {
        $file3 = $this->makeFile(3);
        $this->assertEquals(['490067715','123456789','490067715'], $this->ocr->processFile($file3));
    }
}
