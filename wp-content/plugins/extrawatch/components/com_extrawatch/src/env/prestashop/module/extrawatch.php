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


// Security
if (!defined('_PS_VERSION_'))
    exit;

class extrawatch extends Module
{

    public function __construct()
    {
        $this->name = 'extrawatch';
        $this->tab = 'Stats'; // back-end name
        $this->version = '2.1.917';
        $this->displayName = 'ExtraWatch FREE';
		$this->tab = 'analytics_stats'; 
		
		
		
		$this->module_key='aefa1ec20ddd7cdc116f9ea27c215595';
		
		

        parent::__construct();

        $this->displayName = $this->l('ExtraWatch Live Stats and Visitor Counter');
		
		
        $this->description = $this->l('Real-time Live Stats, Graphs, Goals, Nightly emails. ExtraWatch allows you to watch your visitors and bots in real-time from the administration back-end. Especially their IP addresses, countries they come from, which pages they are viewing, their browser and operating system, it creates daily and all-time stats from these information plus unique, pageload and total hits statistics. Furthermore, you can block harmful IP addresses and see blocked attempts stats.');
		
		
		
		
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module ?');
    }


    public function install()
    {

        $parentTabId = (int)Tab::getIdFromClassName('AdminStats');

        if(!parent::install()
            || !$this->registerHook('leftColumn')
            || !Configuration::updateValue('MOD_EXTRAWATCH_IMG', 'http://extrawatch.com/logo.jpg')
            || !$this->installModuleTab('ExtraWatchAdmin', 'ExtraWatch Stats', $parentTabId))
            return false;

        define("ENV", 1);
        define("_JEXEC",1);
        $dirname = dirname(__FILE__);

        $rootDir = realpath(realpath(dirname(__FILE__)).DS."..".DS."..");
        $extensionDir = realpath($rootDir.DS."modules".DS."extrawatch".DS."extrawatch");

        define("JPATH_BASE", $extensionDir);
        define("JPATH_BASE2", $extensionDir);
        define("JPATH_SITE", $extensionDir);

        $incToInclude = $extensionDir.DS."components".DS."com_extrawatch".DS."src".DS."inc.extrawatch.env.php";
        require_once($incToInclude);

        $installToInclude = $extensionDir.DS."administrator".DS."components".DS."com_extrawatch".DS."install.extrawatch.php";
        require_once($installToInclude);

        $env = ExtraWatchEnvFactory::getEnvironment();
        $database = $env->getDatabase();
        $this->extrawatch_initialize_db(JPATH_BASE, $env);
        $output = extrawatch_initialize_ip2country(JPATH_BASE2, $database);

        $this->extrawatch_fixFilePermissions();

        return true;
    }

    public function uninstall()
    {
        if(!parent::uninstall()
            || !Configuration::deleteByName('MOD_EXTRAWATCH_IMG')
            || !$this->uninstallModuleTab('ExtraWatchAdmin'))
            return false;
        return true;
    }

    public function getContent()
    {
        $html = '';
        return $html;
    }


    public function hookleftColumn($params) {
        global $smarty;
        $smarty->assign('EXTRAWATCH_IMG', Configuration::get('MOD_EXTRAWATCH_IMG'));

        if (!defined("_JEXEC")) define("_JEXEC",1);
        if (!defined("ENV")) define("ENV",1);
        $env = "ExtraWatchPrestaShopEnv"; //TODO must refactor
        $pathSuffix = realpath(dirname(__FILE__)).DS."extrawatch";

        if (!defined("JPATH_BASE")) {
            define("JPATH_BASE", $pathSuffix);
        }
        require_once($pathSuffix.DS."modules".DS."mod_extrawatch_agent".DS."mod_extrawatch_agent.php");
        $extraWatchAgentOutput = renderExtraWatchAgent();
        $smarty->assign('EXTRAWATCH_AGENT_OUTPUT', $extraWatchAgentOutput);

        require_once($pathSuffix.DS."modules".DS."mod_extrawatch_users".DS."mod_extrawatch_users.php");
        $extraWatchUsersOutput = renderExtraWatchUsers();
        $smarty->assign('EXTRAWATCH_USERS_OUTPUT', $extraWatchUsersOutput);

        require_once($pathSuffix.DS."modules".DS."mod_extrawatch_visitors".DS."mod_extrawatch_visitors.php");
        $extraWatchVisitorsOutput = renderExtraWatchVisitors();
        $smarty->assign('EXTRAWATCH_VISITORS_OUTPUT', $extraWatchVisitorsOutput);

        return $this->display(dirname(__FILE__), 'extrawatch.tpl');
    }

    private function installModuleTab($tabClass, $tabName, $idTabParent) {
        @copy(_PS_MODULE_DIR_.$this->name.'/logo.gif', _PS_IMG_DIR_.'t/'.$tabClass.'.gif');
        $tab = new Tab();
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $tabName;
        }
        $tab->class_name = $tabClass;
        $tab->module = $this->name;
        $tab->id_parent = $idTabParent;
        if(!$tab->save())
            return false;
        return true;
    }

    private function uninstallModuleTab($tabClass) {
        $idTab = Tab::getIdFromClassName($tabClass);
        if($idTab != 0)
        {
            $tab = new Tab($idTab);
            $tab->delete();
            return true;
        }
        return false;
    }

    function extrawatch_initialize_db($modulePath, $env) {
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


    function extrawatch_fixFilePermissions() {
        $filesArray = array(
            "img.php",
            "timezone.php",
            "ajax" . DIRECTORY_SEPARATOR . "block.php",
            "ajax" . DIRECTORY_SEPARATOR . "last.php",
            "ajax" . DIRECTORY_SEPARATOR . "lastvisit.php",
            "ajax" . DIRECTORY_SEPARATOR . "sizequery.php",
            "ajax" . DIRECTORY_SEPARATOR . "sizequerytotal.php",
            "ajax" . DIRECTORY_SEPARATOR . "stats.php",
            "ajax" . DIRECTORY_SEPARATOR . "tooltip.php",
            "ajax" . DIRECTORY_SEPARATOR . "trendtooltip.php",
            "ajax" . DIRECTORY_SEPARATOR . "vars.php",
            "ajax" . DIRECTORY_SEPARATOR . "visits.php",
            "ajax" . DIRECTORY_SEPARATOR . "heatmap.php",
            "ajax" . DIRECTORY_SEPARATOR . "img.php",
            "js" . DIRECTORY_SEPARATOR . "extrawatch.js.php",
            "js" . DIRECTORY_SEPARATOR . "maps.js.php");

        foreach($filesArray as $file) {
            $file = JPATH_SITE.DIRECTORY_SEPARATOR."components".DIRECTORY_SEPARATOR."com_extrawatch".DIRECTORY_SEPARATOR.$file;
            //echo("changing permissions of file: $file");
            @chmod($file, 0755);
        }
    }


}
