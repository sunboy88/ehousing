<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchGoalsTest extends ExtraWatchTestBase
{


    public function testGoals_saveGoal()
    {
        $totalBefore = sizeof($this->extraWatch->goal->getGoals());
        $_POST["NAME"] = "my test goal";
        $this->extraWatch->goal->saveGoal($_POST);
        $totalAfter = sizeof($this->extraWatch->goal->getGoals());
        $this->assertEquals($totalAfter, $totalBefore+1);

    }


    /**
     * @expectedException ExtraWatchIPBlockedException
     * This should throw an exception
     */
    public function testGoals_testCameFromBlocking()
    {
        $totalBefore = sizeof($this->extraWatch->goal->getGoals());
        $_POST["NAME"] = "my blocking test goal";
        $_POST["CAME_FROM_CONDITION"] = "*google.sk*";
        $_POST["BLOCK"] = "1";
        $this->extraWatch->goal->saveGoal($_POST);
        $totalAfter = sizeof($this->extraWatch->goal->getGoals());
        $this->assertEquals($totalAfter, $totalBefore+1);

        $this->assertEmpty($this->extraWatch->block->getBlockedIPs());

        $_SERVER['HTTP_REFERER'] = self::REFERER_GOOGLE_SK;

        $this->assertEmpty($this->extraWatch->block->getBlockedIPs());

        $this->extraWatch->visit->insertVisit();

    }


}