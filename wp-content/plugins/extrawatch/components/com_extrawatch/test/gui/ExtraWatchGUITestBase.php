<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
require_once 'PHPUnit/Extensions/SeleniumTestCase/Driver.php';

abstract class ExtraWatchGUITestBase extends PHPUnit_Extensions_Selenium2TestCase
{

    const JOOMLA_PATH = "http://codegravitydemo.com/joomla3.0/PRO/administrator/";
    const WP_PATH = "http://codegravitydemo.com/wordpress/PRO/wp-admin/";

    protected function setUp() {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://codegravitydemo.com/joomla3.0/PRO/administrator/');
    }

}
?>
