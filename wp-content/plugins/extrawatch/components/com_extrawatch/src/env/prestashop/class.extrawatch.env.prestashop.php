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
if (!defined('_JEXEC') && !defined('_VALID_MOS'))  {
  die('Restricted access');
}

class ExtraWatchPrestaShopEnv implements ExtraWatchEnv
{
  const EW_ENV_NAME = "PrestaShop";

  function __construct() {
  }

  function getDatabase()
  {
    return new ExtraWatchDBWrapPrestaShop();
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
    $subdir = str_replace("/index.php", "", $scriptName);

    $adminDirName = $this->getAdminDirName();
    $subdir = str_replace("/".$adminDirName, "", $subdir);

	$url = parse_url($hostname . $subdir);
	$liveSitePath = $url['path'];

    return $liveSitePath . "/modules/extrawatch/extrawatch/";
  }

    function getAdminDir()
  {
    return "";
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
    return "";
  }

  function renderLink($task, $otherParams)
  {
    return "index.php?controller=ExtraWatchAdmin&token=".Tools::getValue('token')."&task=$task&action=$otherParams";
  }

  function getUser()
  {
    return "matto";
  }

  function getTitle()
  {
    global $smarty;
    return $smarty->tpl_vars['meta_title']->value;
  }

  function getUsername()
  {
    global $user;
    if ($user && $user->uid) {
      return @$user->name;
    }
    return "";
  }

  function getAdminEmail()
    {
        global $user;
        if ($user && $user->uid) {
            return @$user->email;
        }
        return "";
    }

    function sendMail($recipient, $sender, $recipient, $subject, $body, $true, $cc, $bcc, $attachment, $replyto, $replytoname)
  {
    //TODO send mail
  }

  function getDbPrefix()
  {
    return _DB_PREFIX_;
  }

  function getTimezoneOffset()
  {
    return 0; //TODO must implement
  }

  function getAllowedDirsToCheckForSize()
  {
    // TODO: Implement getDirsToCheckForSize() method.
  }

  function getDirsToCheckForSize($directory)
  {
    $dirs = array();

    $dirs[ExtraWatchSizes::SCAN_DIR_MAIN] = "..";
    $dirs[ExtraWatchSizes::SCAN_DIR_ADMIN] = "../administrator";

    $dirs[ExtraWatchSizes::REAL_DIR_MAIN] = "..";
    $dirs[ExtraWatchSizes::REAL_DIR_ADMIN] = "../administrator";

    return $dirs;
  }

  /**
   * env
   * @return unknown
   */
  function getAgentNotPublishedMsg($database) {
    //TODO implement
    return FALSE;
  }

  function getFormKey() {
        return "";
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

    private function getAdminDirName() {
        $adminDir = realpath(_PS_ADMIN_DIR_);
        $adminDirSplitted = explode(DIRECTORY_SEPARATOR,$adminDir);
        $lastDir = $adminDirSplitted[sizeof($adminDirSplitted)-1];
        return $lastDir;
    }

    function getUserId()
    {
        //TODO implement
    }

    public function getUsernameById($userId) {
        //TODO implement
    }

}


