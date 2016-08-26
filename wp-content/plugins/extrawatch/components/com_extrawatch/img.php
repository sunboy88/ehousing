<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 1.2.18
 * @revision 270
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2012 by Matej Koval - All rights reserved!
 * @website http://www.codegravity.com
 */

include_once "includes.php";

$extraWatch = new ExtraWatch();
$extraWatchHTML = new ExtraWatchHTML();

if (!EXTRAWATCH_DEBUG) {
    header('Content-Type: image/gif');

    if ($extraWatch->config->isAdFree() && $extraWatch->config->getCheckboxValue('EXTRAWATCH_FRONTEND_HIDE_LOGO'))
        readfile(JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "img" .DS. "icons" . DS . "extrawatch-logo-16x16-blank.gif");
    else
        readfile(JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "img" .DS. "icons" . DS . "extrawatch-logo-16x16.gif");

}

$redirURI = @ $_SERVER[$extraWatch->config->getConfigValue('EXTRAWATCH_SERVER_URI_KEY')];
$uri = $extraWatch->helper->getURI();

if (@ $redirURI && @ substr($redirURI, -9, 9) != "index.php")
    $uri = $redirURI;

$extraWatch->visit->updateVisitByBrowser($uri);

//die();

