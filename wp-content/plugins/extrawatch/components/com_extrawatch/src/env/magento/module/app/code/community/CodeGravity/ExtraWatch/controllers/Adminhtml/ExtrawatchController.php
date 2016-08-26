<?php
/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 1.2.18
 * @revision 313
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2012 by CodeGravity.com - All rights reserved!
 * @website http://www.extrawatch.com
 */

class CodeGravity_ExtraWatch_Adminhtml_ExtraWatchController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction() {
        $this->renderOutput();
    }

    public function flowAction() {
        $this->renderOutput("flow");
    }

    public function seoAction() {
        $this->renderOutput("seo");
    }

    public function heatmapAction() {
        $this->renderOutput("heatmap");
    }

    public function graphsAction() {
        $this->renderOutput("graphs");
    }

    public function goalsAction() {
        $this->renderOutput("goals");
    }
    public function historyAction() {
        $this->renderOutput("history");
    }
    public function antispamAction() {
        $this->renderOutput("antiSpam");
    }
    public function emailsAction() {
        $this->renderOutput("emails");
    }
    public function licenseAction() {
        $this->renderOutput("license");
    }
    public function dbstatusAction() {
        $this->renderOutput("status");
    }
    public function sizesAction() {
        $this->renderOutput("sizes");
    }
    public function settingsAction() {
        $this->renderOutput("settings");
    }
    public function creditsAction() {
        $this->renderOutput("credits");
    }

    private function renderOutput($task = "")
    {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock(
            'Mage_Core_Block_Template',
            'CodeGravity_ExtraWatch_Block_Adminhtml_ExtraWatch',
            array('template' => 'extrawatch/extrawatch.phtml')
        );

        define("ENV", 1);
        define("_JEXEC", 1);
        $magentoDir = realpath(dirname(__FILE__) . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS . ".." . DS);

        $dir = realpath($magentoDir . DS . "app" . DS . "code" . DS . "community" . DS . "CodeGravity" . DS . "ExtraWatch" . DS . "extrawatch");
        define("JPATH_BASE2", $dir);
        require_once($magentoDir . DS . "app" . DS . "code" . DS . "community" . DS . "CodeGravity" . DS . "ExtraWatch" . DS . "extrawatch" . DS . "administrator" . DS . "components" . DS . "com_extrawatch" . DS . "admin.extrawatch.php");
        $output = extrawatch_mainController($task);

        $block->setData("output", $output);
        $this->getLayout()->getBlock('content')->append($block);

        $this->renderLayout();
    }



}