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

class CodeGravity_ExtraWatch_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('extrawatch')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('extrawatch')->__('Disabled')
        );
    }
}