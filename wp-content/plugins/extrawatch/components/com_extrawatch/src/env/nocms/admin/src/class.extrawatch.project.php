<?php

/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.2
 * @revision 123
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2013 by CodeGravity.com - All rights reserved!
 * @website http://www.extrawatch.com
 */

defined('_JEXEC') or die('Restricted access');

class ExtraWatchProject
{

    public $env;
    public $database;
    const TRIAL_DAYS = 7;
    const PAYMENT_PERIOD_DAYS = 30;

    function __construct($database)
    {
        $this->env = ExtraWatchEnvFactory::getEnvironment();
        $this->database = $database;
    }

    function isProjectAlwaysActive($projectId) {
        $query = sprintf("select alwaysActive from global_extrawatch_project where id = '%d'", (int) $projectId);
        return $this->database->resultQuery($query);
    }

    function isPaymentActive($projectId) {
        $query = sprintf("select lastPayment from global_extrawatch_project where id = '%d'", (int) $projectId);
        $lastPayment = $this->database->resultQuery($query);

        $daysPaymentActive = (time() - $lastPayment) / 3600 / 24;
        if (self::PAYMENT_PERIOD_DAYS - $daysPaymentActive > 0) {
            return TRUE;
        }
        return FALSE;
    }

    function setTimeOfProjectCreation($projectId) {
        $query = sprintf("update global_extrawatch_project set timeOfCreation = '%d' where timeOfCreation is null and id = '%d' ", time(), $projectId);
        $this->database->executeQuery($query);
    }


    function getDaysToTrialEnd($projectId) {
        $query = sprintf("select timeOfCreation from global_extrawatch_project where `lastPayment` is NULL and id = '%d'", (int) $projectId);
        $timeOfCreation = $this->database->resultQuery($query);
		echo("<!-- creation: ".date("d.m.Y", $timeOfCreation) . " -->");
        $actualTime = ExtraWatchDate::getUTCTimestamp();
        $daysSinceCreation = ($actualTime - $timeOfCreation) / 3600 / 24;
        $daysTillTrialEnd = ceil(self::TRIAL_DAYS - $daysSinceCreation);
        return $daysTillTrialEnd;
    }



}


