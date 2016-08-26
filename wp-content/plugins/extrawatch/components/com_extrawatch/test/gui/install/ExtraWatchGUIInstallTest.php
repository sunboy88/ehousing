<?php

require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchGUITestBase.php");

class ExtraWatchGUIInstallTest extends ExtraWatchGUITestBase {

    public function testWordpress() {
        $this->open('/wordpress/PRO/');
        $this->assertTextPresent('ExtraWatch PRO wordpress demo');
    }


}
?>
