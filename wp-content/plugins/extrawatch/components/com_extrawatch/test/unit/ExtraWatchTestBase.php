<?php

abstract class ExtraWatchTestBase extends PHPUnit_Framework_TestCase
{
    protected $extraWatch;
    protected $day;

    const USER_AGENT_HTC_DESIRE_Z = "Mozilla/5.0 (Linux; U; Android 2.3.3; en-gb; HTC_DesireZ_A7272 Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1";
    const REFERER_GOOGLE_SK = "https://www.google.sk/url?sa=t&rct=j&q=test+query&esrc=s&source=web&cd=1&cad=rja&ved=0CCsQFjAA&url=http%3A%2F%2Fstackoverflow.com%2Fquestions%2F834303%2Fphp-startswith-and-endswith-functions&ei=s3fNUZfgHtGQswad8YCIDw&usg=AFQjCNGclgW9oIQ9p3H4x6WjW8G1BH-BdA&bvm=bv.48572450,d.Yms";

    protected function setUp()
    {
        if (!defined('ENV')) {  //setting up only once
            define('DS', DIRECTORY_SEPARATOR);
            define('JPATH_BASE',realpath(dirname(__FILE__).DS."..".DS.".."));
            define('ENV',1);
            define('_EW_PROJECT_ID',"");
        }

        $this->instantiateExtraWatch();
        $this->prepareDB(true);

        $this->day = ExtraWatchDate::jwDateToday();
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYWORDS, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYPHRASE, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_SEARCH_RESULT_NUM, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYWORDS, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYPHRASE, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_REFERERS, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_OS, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_DEVICES, $this->day));
        $this->assertEmpty($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_BROWSER, $this->day));



    }

    public function prepareDB($doNotInitializeIp2c) {
        $this->extraWatch->setup->dropTables(); //initial state
        $this->assertEquals(sizeof($this->extraWatch->setup->getExtraWatchTables()), 0);

        $this->extraWatch->setup->initializeDB($doNotInitializeIp2c);
        $this->assertEquals(sizeof($this->extraWatch->setup->getExtraWatchTables()), 23);
    }

    protected function instantiateExtraWatch()
    {
        require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "includes.php";
        $this->extraWatch = new ExtraWatchMain();
    }

}