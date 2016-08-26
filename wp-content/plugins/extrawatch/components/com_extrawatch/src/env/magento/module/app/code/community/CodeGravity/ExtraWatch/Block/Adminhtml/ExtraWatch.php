<?php
/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.1
 * @revision 917
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2014 by CodeGravity.com - All rights reserved!
 * @website http://www.extrawatch.com
 */
class CodeGravity_ExtraWatch_Block_Adminhtml_ExtraWatch extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();

        define("ENV", 1);
        define("_JEXEC",1);
        $dir = realpath(realpath('.').DS."app".DS."code".DS."community".DS."CodeGravity".DS."ExtraWatch".DS."extrawatch");
        define("JPATH_BASE2", $dir);
        require_once("app".DS."code".DS."community".DS."CodeGravity".DS."ExtraWatch".DS."extrawatch".DS."administrator".DS."components".DS."com_extrawatch".DS."admin.extrawatch.php");

        $output = extrawatch_mainController();
        $this->setData("output", $output);
        $this->setTemplate('extrawatch".DS."extrawatch.phtml');
    }
}