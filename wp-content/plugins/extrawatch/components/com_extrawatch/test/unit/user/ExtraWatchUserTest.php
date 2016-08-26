<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchUserTest extends ExtraWatchTestBase
{

    public function testUser_userActivity()
    {
        $this->simulateVisitFromGoogle();
        $keyPhrase = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYPHRASE, $this->day);
        $this->assertEquals($keyPhrase[0]->name, "test query");
    }


}