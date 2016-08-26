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
class CodeGravity_ExtraWatch_Block_ExtraWatch extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getExtraWatchMain()
     { 
        if (!$this->hasData('extrawatch')) {
            $this->setData('extrawatch', Mage::registry('extrawatch'));
        }
        return $this->getData('extrawatch');
        
    }
}