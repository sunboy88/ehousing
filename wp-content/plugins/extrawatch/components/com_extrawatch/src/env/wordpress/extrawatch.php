<?php
/*
Plugin Name: ExtraWatch FREE (Live Stats, Heatmap, Click tracking, Download Monitor and more)  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
Plugin URI: http://www.extrawatch.com  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

Description: Features: <strong>Visitor Live Stats</strong>, <strong>Front-end Counters</strong>, <strong>Anti-spam</strong>, <strong>Nightly Email Reports</strong>, <strong>History</strong>, <strong>Graphs</strong>, translated in <strong>42 world languages</strong>  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  


Version: 2.3.2650 FREE  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
Author: CodeGravity.com  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
Author URI: http://www.extrawatch.com  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
*/

/** using native directory separator for paths */  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
if (!defined('DS'))  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  define ('DS', DIRECTORY_SEPARATOR);  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

if (!defined('_JEXEC')) define("_JEXEC", 1);  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

if (!defined("ENV")) {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
	define("ENV", 1);
}

if (!defined('JPATH_BASE2')) define("JPATH_BASE2", dirname(__FILE__));  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
if (!defined('JPATH_BASE')) define("JPATH_BASE", dirname(__FILE__));  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
if ( ! defined( 'WP_PLUGIN_DIR' ) )  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins' );  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

if ( ! defined( '_EW_PROJECT_ID' ) )   	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
	define("_EW_PROJECT_ID", FALSE);  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  function getExtraWatchURL() {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

	if ( function_exists('plugins_url') ) {
		$pluginUrl = plugins_url();
	} else {
		$pluginUrl = WP_PLUGIN_URL;
	}

    
    $extraWatchPath = $pluginUrl."/extrawatch/";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    
    
    

    return $extraWatchPath;  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  }




add_action('plugins_loaded', 'extrawatch_menu');

//including main stylesheet to header to prevent blinking
if (strstr($_SERVER['REQUEST_URI'],'?page=extrawatch')) {   //loading only if actual plugin body is requested

	require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "includes.php");

    $env = ExtraWatchEnvFactory::getEnvironment();
    $extraWatch = new ExtraWatchMain();

    $extraWatch->config->saveRandValue(); //this is because we have to set rand value because ajax link uses security token generated from rand value

    wp_enqueue_style("dashboard.css.php",  getExtraWatchURL()."/".$env->renderBackendAjaxLink($extraWatch->config,"ajax","dashboard.css&env=ExtraWatchWordpressEnv"));
}


function extrawatch_menu() {
    $extraWatchURL = getExtraWatchURL();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
	if(!@function_exists("add_menu_page")) {
		$wpBase = realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."..");
		require_once($wpBase.DIRECTORY_SEPARATOR."wp-admin".DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."plugin.php");
	} 
	$EC_userLevel = 'level_7';  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
	if (function_exists("add_menu_page")) {
		add_menu_page('ExtraWatch', 'ExtraWatch', $EC_userLevel, 'extrawatch', 'ew_plugin_options', $extraWatchURL.'components/com_extrawatch/img/icons/extrawatch-logo-16x16.png');
	}

}

	
	
/* this fixes double require by wordpress*/  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
if (!function_exists("extrawatch_admin_menu")) {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  function ew_plugin_options()  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  {


    $extraWatchPath = getExtraWatchPath();

      if (!current_user_can('edit_pages')) {
      wp_die(__('You do not have sufficient permissions to access this page.'));  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    }
    echo '<div class="wrap">';  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    require_once $extraWatchPath . "components" . DS . "com_extrawatch" . DS . "config.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    require_once $extraWatchPath . "components" . DS . "com_extrawatch" . DS . "src" . DS. "inc.extrawatch.env.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    require_once $extraWatchPath . "administrator" . DS . "components" . DS . "com_extrawatch" . DS . "admin.extrawatch.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

    echo extrawatch_mainController();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

    echo '</div>';
  }


  function extrawatch_frontend_agent()  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  {
    include_once getExtraWatchPath() . "modules" . DS . "mod_extrawatch_agent" . DS . "mod_extrawatch_agent.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    echo renderExtraWatchAgent();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  }


  function extrawatch_frontend_users()  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  {
    include_once getExtraWatchPath() . "modules" . DS . "mod_extrawatch_users" . DS . "mod_extrawatch_users.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    echo renderExtraWatchUsers();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
}

  function extrawatch_frontend_visitors()  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  {
    include_once getExtraWatchPath() . "modules" . DS . "mod_extrawatch_visitors" . DS . "mod_extrawatch_visitors.php";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    echo renderExtraWatchVisitors();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  }
  
  function extrawatch_frontend()  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  {
    echo("<br/>");
	extrawatch_frontend_agent();
    extrawatch_frontend_users();  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
	extrawatch_frontend_visitors();
  }


  function getExtraWatchPath() {  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    
    $extraWatchPath = WP_PLUGIN_DIR."/extrawatch/";  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
    
    
    

    return $extraWatchPath;  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  }

}

  //add_action('admin_menu', 'extrawatch_admin_menu');  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "src" . DS. "class.extrawatch.log.php");  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "src" . DS. "inc.extrawatch.env.php");  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "src" . DS. "env". DS. "wordpress" . DS . "widget" . DS . "class.extrawatch.agent.widget.php");  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "src" . DS. "env". DS. "wordpress" . DS . "widget" . DS . "class.extrawatch.users.widget.php");  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "src" . DS. "env". DS. "wordpress" . DS . "widget" . DS . "class.extrawatch.visitors.widget.php");  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  register_activation_hook(__FILE__, array('ExtraWatchEnvSetupWordpress', 'install'));  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
  register_deactivation_hook(__FILE__, array('ExtraWatchEnvSetupWordpress', 'uninstall'));  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  

  add_action('wp_head','extrawatch_head_frontend');


//including main stylesheet to header to prevent blinking
if (strstr($_SERVER['REQUEST_URI'],'?page=extrawatch')) {   //loading only if actual plugin body is requested

    require_once(JPATH_BASE2 . DS . "components" . DS . "com_extrawatch" . DS . "includes.php");

    $env = ExtraWatchEnvFactory::getEnvironment();
    $extraWatch = new ExtraWatchMain();
    wp_enqueue_style("dashboard.css.php",  getExtraWatchURL()."/".$env->renderBackendAjaxLink($extraWatch->config,"ajax","dashboard.css&env=ExtraWatchWordpressEnv"));
}


	function extrawatch_head_frontend() {
		echo "<script type='text/javascript' src='".getExtraWatchURL()."components/com_extrawatch/js/extrawatch.js'></script>\n";
	
	}

add_action( 'init', 'extrawatch_register_shortcodes');	

function extrawatch_register_shortcodes(){
   add_shortcode('extraWatchAgent', 'extrawatch_frontend_agent');
   add_shortcode('extraWatchUsers', 'extrawatch_frontend_users');
   add_shortcode('extraWatchVisitors', 'extrawatch_frontend_visitors');
}


unset($_GET['error'] );  	 	    	    		  	 	  	 	  		 	 		    	 			 	   		  	 	 		 	 	   	      	  	 		 		 				 			 		  		    	 		 		  
