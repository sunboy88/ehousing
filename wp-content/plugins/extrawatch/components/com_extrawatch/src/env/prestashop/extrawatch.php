<?php
/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 1.2.18
 * @revision 365
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2012 by Matej Koval - All rights reserved!
 * @website http://www.codegravity.com
 */


// Security
if (!defined('_PS_VERSION_'))
    exit;

class ExtraWatchFrontend extends Module
{

    public function __construct()
    {
        $this->name = 'extrawatch';
        $this->tab = 'ExtraWatch'; // back-end name
        $this->version = '1.2.18';
        $this->displayName = 'ExtraWatch';
        $this->module_key = '';

        parent::__construct();

        $this->description = $this->l('ExtraWatch description');

        /** Backward compatibility 1.4 / 1.5 */
        require(dirname(__FILE__).'/backward_compatibility/backward.php');

        if (Configuration::get('EXTRAWATCH_ACTIVATE') == 1 && (strlen(Configuration::get('EXTRAWATCH_USERNAME')) < 3 || strlen(Configuration::get('EXTRAWATCH_PASSWORD')) < 3))
            $this->warning = $this->l('The module is activated but api key or secret key are not correctly set.');

    }


    public function install()
    {
        // Install module
        if (!parent::install())
            return false;

        return true;
    }

    public function uninstall()
    {
        return true;
    }


    public function getContent()
    {
        $output = "";

        return $output;
    }
}
