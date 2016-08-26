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

function ExtraWatchMain() {
  define('JPATH_BASE2', dirname(__FILE__));
  define('_JEXEC', 1);
  if (!defined('ENV')) define('ENV', 1);
  include('administrator/components/com_extrawatch/admin.extrawatch.php');
}
