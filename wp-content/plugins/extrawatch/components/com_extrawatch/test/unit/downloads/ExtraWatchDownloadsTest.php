<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchDownloadsTest extends ExtraWatchTestBase
{

    public function testDownloads_addExtension()
    {
        $extensionCountBefore = sizeof($this->extraWatch->downloads->getAllExtensions());
        $this->extraWatch->downloads->addExtension("zip");
        $extensionCountAfter = sizeof($this->extraWatch->downloads->getAllExtensions());
        $this->assertEquals($extensionCountAfter, $extensionCountBefore+1);
    }

    public function testDownloads_addFilePath()
    {
        $fileCountBefore = sizeof($this->extraWatch->downloads->getAllFilePaths());
        $this->extraWatch->downloads->addFilePath("c:\\somefile.zip");
        $fileCountAfter = sizeof($this->extraWatch->downloads->getAllFilePaths());
        $this->assertEquals($fileCountAfter, $fileCountBefore+1);
    }


}