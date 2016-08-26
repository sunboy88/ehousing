<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchVisitsTest extends ExtraWatchTestBase
{

    const PAGE_URI = "/";

    public function testVisit_referers()
    {
        $_SERVER['HTTP_USER_AGENT'] = self::USER_AGENT_HTC_DESIRE_Z;
        $_SERVER['HTTP_REFERER'] = self::REFERER_GOOGLE_SK;

        $this->extraWatch->visit->updateVisitByBrowser("/", self::REFERER_GOOGLE_SK);

        $referer = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_REFERERS, $this->day);
        $this->assertEquals($referer[0]->name,"www.google.sk");
    }


    public function testVisit_browser()
    {
        $_SERVER['HTTP_USER_AGENT'] = self::USER_AGENT_HTC_DESIRE_Z;
        $_SERVER['HTTP_REFERER'] = self::REFERER_GOOGLE_SK;

        $this->extraWatch->visit->updateVisitByBrowser("/", self::REFERER_GOOGLE_SK);

        $mobileBrowser = ($this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_BROWSER, $this->day));
        $this->assertNotEmpty($mobileBrowser);
        $this->assertEquals($mobileBrowser[0]->name, "Safari");
    }


    public function testVisit_mobileDevices()
    {

        $_SERVER['HTTP_USER_AGENT'] = self::USER_AGENT_HTC_DESIRE_Z;
        $_SERVER['HTTP_REFERER'] = self::REFERER_GOOGLE_SK;

        $this->extraWatch->visit->updateVisitByBrowser("/", self::REFERER_GOOGLE_SK);

        $mobileDeviceJSON = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_DEVICES, $this->day);
        $mobileDevice = json_decode($mobileDeviceJSON[0]->name);

        $this->assertEquals($mobileDevice->name, "HTC_DesireZ_A7272 Build/GRI40");
        $this->assertEquals($mobileDevice->icon, "android.png");

        $mobileOSJSON = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_OS, $this->day);
        $mobileOS = json_decode($mobileOSJSON[0]->name);
        $this->assertEquals($mobileOS->name, "Android");
        $this->assertEquals($mobileOS->icon, "android.png");
    }


}