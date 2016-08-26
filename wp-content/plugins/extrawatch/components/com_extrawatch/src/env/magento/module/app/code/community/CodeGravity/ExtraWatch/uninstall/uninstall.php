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

$thisDir = realpath(dirname(__FILE__));
$magentoPath =  realpath($thisDir.DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS."..".DS);

require_once $magentoPath.'/app/Mage.php';
umask(0);

//Run Mage app
Mage::app('default');

$setup->startSetup();

echo 'Cleaning tables ';

$tablesToRemove = array(
"#__extrawatch",
"#__extrawatch_info",
"#__extrawatch_config",
"#__extrawatch_blocked",
"#__extrawatch_ip2c",
"#__extrawatch_cc2c",
"#__extrawatch_uri",
"#__extrawatch_cache",
"#__extrawatch_goals",
"#__extrawatch_internal",
"#__extrawatch_uri2title",
"#__extrawatch_history",
"#__extrawatch_uri_history",
"#__extrawatch_flow",
"#__extrawatch_uri_post",
"#__extrawatch_keyphrase",
"#__extrawatch_uri2keyphrase",
"#__extrawatch_heatmap",
"#__extrawatch_uri2keyphrase_pos"
);

foreach ($tablesToRemove as $table) {
    $setup->run("DROP TABLE $table");
    echo 'dropped table $table - [OK]<br />';
}


$setup->endSetup();

echo 'ExtraWatch extension was completely removed';

?>