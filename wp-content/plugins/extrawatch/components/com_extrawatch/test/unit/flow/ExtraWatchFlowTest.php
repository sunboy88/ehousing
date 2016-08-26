<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchFlowTest extends ExtraWatchTestBase
{
    const PAGE_1 = "/page1";
    const PAGE_2 = "/page2";


    public function testFlow_getOutputPages() {
        $this->extraWatch->flow->insertFlow(self::PAGE_1, self::PAGE_2);
        $uri2titleIdPage1 = $this->extraWatch->visit->getUriIdByUriName(self::PAGE_1);
        $this->assertNotNull($uri2titleIdPage1);
        $uri2titleIdPage2 = $this->extraWatch->visit->getUriIdByUriName(self::PAGE_2);
        $this->assertNotNull($uri2titleIdPage1);
        $outputPages = $this->extraWatch->flow->getOutputPages($uri2titleIdPage1, 1);
        $this->assertNotEmpty($outputPages);
        $this->assertEquals($outputPages[0]->from, $uri2titleIdPage1);
        $this->assertEquals($outputPages[0]->to, $uri2titleIdPage2);
    }


}