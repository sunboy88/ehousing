<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.1
 * @revision 917
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2014 by CodeGravity.com - All rights reserved!
 * @website http://www.codegravity.com
 */

define('_JEXEC', 1);
$dirname = dirname(__FILE__);
$dirnameExploded = explode(DIRECTORY_SEPARATOR, $dirname);
$jBasePath = "";
$omitLast = 3;
for ($i = 0; $i < sizeof($dirnameExploded) - $omitLast; $i++) {
    $jBasePath .= $dirnameExploded[$i];
    if ($i < (sizeof($dirnameExploded) - ($omitLast + 1)))
        $jBasePath .= DIRECTORY_SEPARATOR;

}
define('JPATH_BASE', $jBasePath);
define('DS', DIRECTORY_SEPARATOR);

if (!defined('JPATH_ROOT'))
    require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
if (!defined('JDEBUG'))
    require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';

require_once JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'application' . DS . 'module' . DS . 'helper.php';
$mainframe = & JFactory :: getApplication('site');
$mainframe->initialise();

require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "config.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.ip2country.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.block.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.block.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.cache.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.config.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.goal.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.goal.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.helper.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.date.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.stat.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.stat.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.visit.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.visit.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.visit.history.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.visit.history.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.trend.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.log.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "admin.extrawatch.html.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.sizes.php";
require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "class.extrawatch.flow.php";


$extraWatch = new ExtraWatchMain();
$extraWatchHTML = new ExtraWatchHTML();
$extraWatchHTML->renderAdminStyles();

