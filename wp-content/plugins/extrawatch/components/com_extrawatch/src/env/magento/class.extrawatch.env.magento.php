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

/** ensure this file is being included by a parent file */
if (!defined('_JEXEC') && !defined('_VALID_MOS'))
    die('Restricted access');

class ExtraWatchMagentoEnv implements ExtraWatchEnv
{
    const EW_ENV_NAME = "magento";

    function getDatabase()
    {
        return new ExtraWatchDBWrapMagento();
    }

    function getRequest()
    {
        return new EnvRequest();
    }

    function & getURI()
    {
        return "fakeURL";
    }

    function isSSL()
    {
        //TODO change
        return FALSE;
    }

    function getRootSite()
    {
        //print_r($_SERVER);
        $hostname = "http://" . $_SERVER['HTTP_HOST'];
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $subdir = str_replace($this->getAdminDir() . DS . "index.php", "", $scriptName);
        $subdir = str_replace("index.php", "", $scriptName);
		
		$url = parse_url($hostname . $subdir);
		$liveSitePath = $url['path'];

	    return $liveSitePath;
    }

    function getAdminDir()
    {
        return "admin";
    }


    function getCurrentUser()
    {
        return $this->getUsername();
    }

    function getUsersCustomTimezoneOffset()
    {
        return 0;
    }

    function getEnvironmentSuffix()
    {
        return "app/code/community/CodeGravity/ExtraWatch/extrawatch/";
    }

    function renderLink($task, $otherParams)
    {
        return "?task=$task&action=$otherParams";
    }

    function getUser()
    {
        $user = Mage::getSingleton('admin/session')->getUser();
        return $user;
    }

    function getTitle()
    {
        $title = $GLOBALS['extrawatch_page_title'];
        return $title;
    }

    function getAdminEmail()
    {
        $session = Mage::getSingleton('admin/session');
        if($session->isLoggedIn()) {
            $currentUser = $session->getUser();
            return $currentUser->getEmail();
        }
    }

    function getUsername()
    {
        $session = Mage::getSingleton('customer/session');
        if($session->isLoggedIn()) {
            $customer = $session->getCustomer();
            return $customer->getName();
        }

        return "";
    }

    function sendMail($recipient, $sender, $recipient, $subject, $body, $true, $cc, $bcc, $attachment, $replyto, $replytoname)
    {
        $mail = Mage::getModel('core/email');
        $mail->setToName($recipient);
        $mail->setToEmail($recipient);
        $mail->setBody($body);
        $mail->setSubject($subject);
        $mail->setFromEmail($sender);
        $mail->setFromName($sender);
        $mail->setType('html');

        try {
            $mail->send();
            Mage::log("Email to $recipient has been sent");
        }
        catch (Exception $e) {
            Mage::log("Unable to send email to $recipient");
            Mage::logException($e);
        }
    }

    function getDbPrefix()
    {
        $dbPrefix = Mage::getConfig()->getTablePrefix()->asArray();
        return $dbPrefix;
    }

    function getTimezoneOffset()
    {
        return 0; //TODO must implement
    }

    function getAllowedDirsToCheckForSize()
    {
        $dirs = array(
            "../../../../../../"
        );
        return $dirs;
    }

    function getDirsToCheckForSize($directory)
    {
        $dirs = array();

        $dirs[ExtraWatchSizes::SCAN_DIR_MAIN] = "./app/code/community/";
        $dirs[ExtraWatchSizes::SCAN_DIR_ADMIN] = FALSE;

        $dirs[ExtraWatchSizes::REAL_DIR_MAIN] = "../../../../../../";
        $dirs[ExtraWatchSizes::REAL_DIR_ADMIN] = "./";

        return $dirs;
    }

    /**
     * env
     * @return unknown
     */
    function getAgentNotPublishedMsg($database)
    {
        //TODO implement
        return FALSE;
    }

    function getFormKey() {
        return Mage::getSingleton('core/session')->getFormKey();
    }


    public function getReviewLink()
    {
        // TODO: Implement getReviewLink() method.
    }

    public function getVoteLink()
    {
        // TODO: Implement getVoteLink() method.
    }

    public function getEnvironmentName()
    {
        return self::EW_ENV_NAME;
    }
	
    function getUserId()
    {
        //TODO implement
    }

    public function getUsernameById($userId) {
        //TODO implement
    }
 
}


