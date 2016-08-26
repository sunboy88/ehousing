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

class CodeGravity_ExtraWatch_Model_Mysql4_ExtraWatch extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extrawatch_id refers to the key field in your database table.
        $this->_init('extrawatch/extrawatch', 'extrawatch_id');
    }
}