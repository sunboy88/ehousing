<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 1.2.18
 * @revision 404
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2012 by Matej Koval - All rights reserved!
 * @website http://www.codegravity.com
 */
defined('_JEXEC') or die('Restricted access');

/** ensure this file is being included by a parent file */

if (!defined('_JEXEC') && !defined('_VALID_MOS')) {
    die('Restricted access');
}

if (!defined("JPATH_BASE2")) {
    define("JPATH_BASE2", JPATH_BASE);
}

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "includes.php";


function renderExtraWatchAgent()
{

    $output = "";

    $extraWatch = new ExtraWatch();

    require_once JPATH_BASE . DS . "components" . DS . "com_extrawatch" . DS . "lang" . DS . $extraWatch->config->getLanguage() . ".php";

    if (EXTRAWATCH_DEBUG) {
        $output .= ("<span style='color: #ff3333'>" . _JW_DESC_DEBUG . "</span><br/>");
    }

    $extraWatchHTML = new ExtraWatchHTML();
    $extraWatch->block->checkPostRequestForSpam(ExtraWatchHelper::requestGet());
    $extraWatch->block->checkPostRequestForSpam(ExtraWatchHelper::requestPost());
    $extraWatch->visit->insertVisit();

    
    $output .= $extraWatchHTML->renderHeatMapJS();
    


    /*
     * The following piece of code identifies the userAgent and inserts the backlink to codegravity.com
     *
     * I would really appreciate, that you would keep the this unchanged.
     *
     * It took me some time to create and maintain this component and to share it with everyone.
     *
     * This is the least you could kindly do. Thank you.
     *
     *
     * Matej Koval
    */



    $nofollow = "";
    if ($extraWatch->config->isAdFree() && $extraWatch->config->getCheckboxValue("EXTRAWATCH_FRONTEND_NOFOLLOW")) {
        $nofollow = "rel='nofollow'";
    }

    if ($extraWatch->config->isAdFree()) {
        $title = "";
    } else {
        $title = "Real-time visitors monitor and live stats";
    }

    if (!($extraWatch->config->isAdFree() && $extraWatch->config->getCheckboxValue("EXTRAWATCH_FRONTEND_NO_BACKLINK"))) {
        $output .= ("<a href='http://www.codegravity.com' target='_blank' $nofollow title='" . $title . "'>");
    }

    $output .= ("<img src='" . $extraWatch->config->getLiveSiteWithSuffix() . "components/com_extrawatch/ajax/img.php?rand=" . (rand() % 100000) . "&amp;env=" . get_class($extraWatch->env) . "' border='0' alt='$title' title='$title'/>");

    if (!($extraWatch->config->isAdFree() && $extraWatch->config->getCheckboxValue("EXTRAWATCH_FRONTEND_NO_BACKLINK"))) {

        $output .= ("</a>");
    }
    return $output;
}

if (!defined('ENV')) echo renderExtraWatchAgent();


