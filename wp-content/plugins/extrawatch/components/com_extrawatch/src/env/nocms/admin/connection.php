<?php
defined('_JEXEC') or die('Restricted access');

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.2
 * @revision 123
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2013 by CodeGravity.com - All rights reserved!
 * @website http://www.codegravity.com
 */

defined('_JEXEC') or die('Restricted access');

define('_EW_HOST', 'localhost');
define('_EW_USER', 'root');
define('_EW_PASSWORD', '');
define('_EW_DB', 'cg_nocms');
define('_EW_PREFIX', ''); //use blank

define('_EW_GLOBAL_TABLE_PREFIX', 'global');

define('_EW_SCRIPT_HOST',"http://localhost:88");
define('_EW_SCRIPT_HOST_DIR',"/cg/admin/");
define('_EW_EXTRAWATCH_DIR',"extrawatch/");

if (!defined('_EW_CLOUD_MODE')) {
	define('_EW_CLOUD_MODE',1);
}

define('_EW_CLOUD_NOTIFY_EMAIL', 'foo@codegravity.com');



?>