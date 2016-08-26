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

function extrawatch_initialize_db($modulePath, $env)
{
    $lines = file($modulePath . DS . "administrator" . DS . "components" . DS . "com_extrawatch" . DS . "sql" . DS . "install.mysql.utf8.sql");

    $query = "";
    foreach ($lines as $line_num => $line) {

        $query .= trim($line);

        if (strstr($line, ");")) {
            $query = trim($query);
            $query = str_replace("#__", $env->getDbPrefix(), $query);
            $env->getDatabase()->executeQuery($query);
            $query = "";
        }

    }
}


$installer = $this;

$installer->startSetup();

define("ENV", 1);
define("_JEXEC",1);

$dirname = dirname(__FILE__);
Mage::log("namedir: " . $dirname);

$magentoRootDir = realpath($dirname.DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS);
Mage::log("root dir: " . $magentoRootDir);
$extensionDir = realpath($magentoRootDir.DS."app".DS."code".DS."community".DS."CodeGravity".DS."ExtraWatch".DS."extrawatch");
Mage::log("ext dir: " . $extensionDir);

define("JPATH_BASE", $extensionDir);
define("JPATH_BASE2", $extensionDir);
define("JPATH_SITE", $extensionDir);

$incToInclude = $extensionDir.DS."components".DS."com_extrawatch".DS."src".DS."inc.extrawatch.env.php";
Mage::log("inc to include: " . $incToInclude);
require_once($incToInclude);

$installToInclude = $extensionDir.DS."administrator".DS."components".DS."com_extrawatch".DS."install.extrawatch.php";
require_once($installToInclude);
Mage::log("install to include: " . $installToInclude);

$GLOBALS['mageRunCode'] = true;

$env = ExtraWatchEnvFactory::getEnvironment();
Mage::log("env: " . get_class($env));

$database = $env->getDatabase();
Mage::log("database: " . get_class($database));


extrawatch_initialize_db(JPATH_BASE, $env);

Mage::log("db initialized");

$output = extrawatch_initialize_ip2country(JPATH_BASE2, $database);

Mage::log("ip2country updated");

$installer->endSetup();


