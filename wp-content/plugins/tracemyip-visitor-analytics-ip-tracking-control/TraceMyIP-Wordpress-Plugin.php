<?php
/*

 * Plugin Name: Official TraceMyIP Plugin

 * Version: 2.12

 * Plugin URI: http://www.tracemyip.org

 * Description: Adds website visitor IP tracking and Visitor IP blocking to WordPress website. For setup instructions, see <a href="options-general.php?page=TraceMyIP-Wordpress-Plugin.php"><b>plugin settings</b></a>.

 * Author: TraceMyIP.org

 * Author URI: http://www.TraceMyIP.org

*/


### SET LANGUAGE CONSTANTS ############################################
define("tmip_domain_name", 			'tracemyip.org');
define("tmip_service_Nname", 		'TraceMyIP');
define("tmip_service_Dname", 		'TraceMyIP.org');
define("tmip_lang_visitor_tr_code", 'Visitor Tracker Code');
define("tmip_lang_visitr_track_ic", 'Visitor Tracker Icon');
define("tmip_lang_tracker_icon_ps", 'Tracker Icon Position');
define("tmip_lang_page_tr_code", 	'Page Tracker Code');
define("tmip_lang_update_settings", 'Update Settings');


### SET VARIABLE CONSTANTS ############################################
if ($_SERVER['HTTPS']) {
	$tmip_prot='https';
	$tmip_rFsrc='wordpressDBS';
} else {
	$tmip_prot='http';
	$tmip_rFsrc='wordpressDB';
}


// 'false' to set constants case sensitive
// For different provider config, replace prefix tmip
define("tmip_home_page_url", 			
	   $tmip_prot.'://www.'.tmip_domain_name.'');
define("tmip_go_to_projects", 		
	   $tmip_prot.'://www.'.tmip_domain_name.'/members/index.php?rnDs=120&page=my_projects&wMx=1&rFsrc='.$tmip_rFsrc);

define("tmip_free_signup_page_url", 
	   'http://www.'.tmip_domain_name.'/tools/website-visitors-counter-traffic-tracker-statistics/index.php?sto=1'
);
define("tmip_premium_signup_page_url", 
	   'http://www.'.tmip_domain_name.'/members/index.php?page=spm_checkout&type=ssub&ntc=1'
);

define("tmip_visit_tracker_val", 		'tmip_visit_tracker', 	false);
define("tmip_visit_tracker_default", 	'', 					false);

define("tmip_position_val", 			'tmip_position', 		false);
define("tmip_position_default", 		'header', 				false);

define("tmip_page_tracker_val", 		'tmip_page_tracker', 	false);
define("tmip_page_tracker_default", 	'', 					false);



### ADD OPTIONS ############################################
add_option(tmip_visit_tracker_val, 		tmip_visit_tracker_default);
add_option(tmip_page_tracker_val, 		tmip_page_tracker_default);


### ADD USER SETTINGS ############################################
add_action('admin_menu' , 				'add_tmip_option_page');
add_action('admin_menu', 				'tmip_admin_menu');
add_action('wp_head', 					'tmip_addToTags');


### FUNCTIONS ############################################
function tmip_insert_visitor_tracker() {
    $code=get_option(tmip_visit_tracker_val);
    if ($code and strpos($code,'4684NR-IPIB') !== false) {
		$code=stripslashes($code);
		$code=str_replace('src="http:','src="',$code);
		$code=str_replace('src="https:','src="',$code);
		echo $code;
    }
}
function tmip_insert_page_tracker() {
    $code=get_option(tmip_page_tracker_val);
    if ( $code and strpos($code,'tP_lanPTl') !== false) {
		$code=stripslashes($code);
		$code=str_replace('src="http:','src="',$code);
		$code=str_replace('src="https:','src="',$code);
		echo $code;
    }
}
function tmip_addToTags($pid){
   if (is_single()) {
       global $post;
	   $queried_post=get_post($pid);
       $authorId=$queried_post->post_author;
	   ?>
		<script type="text/javascript">
            var _tmip=_tmip || [];
            _tmip.push({"tags": {"author": "<?php the_author_meta( 'nickname', $authorId); ?>"}});
        </script>
	   <?php
   }
}

function tmip_admin_menu() {
	$hook=add_submenu_page(
		'index.php',
		__(''.tmip_service_Nname.' Reports'),
		__(''.tmip_service_Nname.' Reports'),
		'publish_posts',
		'tmip',
		'tmip_reports_page'
	);
	add_action(
		'load-$hook',
		'tmip_reports_load'
	);
	$hook=add_submenu_page(
		'plugins.php',
		__(''.tmip_service_Nname.' Settings'),
		__(''.tmip_service_Nname.' Settings'),
		'manage_options',
		'tmip_admin',
		'tmip_options_page'
	);
}
function tmip_reports_load() {
	add_action(
		'admin_head',
		'tmip_reports_head'
	);
}
function tmip_reports_head() {
	echo '<style type="text/css">body { height: 100%; }</style>';
}

function tmip_reports_page() {
	$tmip_link=tmip_go_to_projects;
	echo '
		<iframe src="'.$tmip_link.'" style="min-height:480px;height:95vh;width:100%;border:none;">
		<p>Your browser does not support iframes which is required by '.service_name.' in order to display the web tracking data within your WordPress dashboard.</p>
		</iframe>
	';
}
function add_tmip_option_page() {
	global $wpdb;
	add_options_page(''.tmip_service_Nname.' Settings', tmip_service_Nname, "manage_options", basename(__FILE__), 'tmip_options_page');

}
function tmip_options_page() {
	
	$output='';
	
	
	$output .='
	<script type="text/javascript">
	function tmip_select_all(id) {
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}
	</script>	
	
	<style>
	#tmip_sett_wrap {
		font-size: 1.1em;
		line-height: 1.5em;
		color: #333321;
		padding: 25px;
		border:1px solid #676767;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		box-shadow: 3px 0px 5px rgba(0, 0, 0, 0.5);
		background-color: #EFECE2;
	}
	#tmip_sett_wrap section {
		font-size: 1.1em;
		color: #333321;
		padding: 25px;
		border:1px solid #676767;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		border-radius: 3px;
		box-shadow: 2px 0px 2px rgba(0, 0, 0, 0.5);
		background-color: #DFDDD7;
	}
	
	.sec_title {
		font-size: 1.3em;
		font-weight:bold;
		margin-top: 50px;
	}
	
	
	.tmip_textarea {
		width: 100%;
		height: 170px;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
       	box-sizing: border-box;		
	}

	#tmip_sett_area {
		width: 100%;
		border-collapse: collapse;
		border:1px solid #676767;
		box-shadow: 2px 0px 2px rgba(0, 0, 0, 0.5);
		background-color: #F3E8C4;
	}
	#tmip_sett_area, th, td {
		border: 1px solid black;
		padding: 5px;
	}
	
	#tmip_sett_wrap ol li {
		font-weight: bold;
		list-style-type: decimal;
		list-style-position: outside;
		padding: 0px;
		margin: 5px;
	}
	#tmip_sett_wrap ol li span {
		font-weight: normal;
	}
	
	#tmip_sett_wrap ul li {
		font-weight: bold;
		list-style: circle;
		list-style-position: outside;
		list-style-type: square;
		padding: 0px;
		margin: 5px;
		margin-left: 30px;
	}
	#tmip_sett_wrap ul li span {
		font-weight: normal;
	}
	
	.tmip_alertRed_div {
		color:#000;
		font-size:1.2em;
		padding:30px;
		margin:20px auto;
		border:10px #DD0000 solid;
		text-align:center;	
		background-color:#FFDDDD;
	}
	.tmip_alertGreen_div {
		color:#000;
		font-size: 1.8em;
		text-align:center;	
		
		padding:30px;
		margin:10px auto;
		border:3px #5CD102 solid;
		background-color:#FFF;
	}
	.tmip_input_box_name {
		color: #B56502;
		font-size: 1.3em;
		font-weight: bold;
		text-align: right;
	}
	.tmip_note {
		padding: 5px;
		font-size: 0.9em;
		font-weight: normal;
	}
	.tmip_tip_important {
		padding: 5px;
		font-size: 0.9em;
		font-weight: normal;
		background-color:#F3C5C5;
	}
	</style>
	';
	
	$output .='<div id="tmip_sett_wrap">';

	
 	if (isset( $_POST['info_update'] ) && check_admin_referer( 'update_tmip_visit_tracker_nonce', 'tmip_visit_tracker_nonce' ) ) {
		$tmip_visit_tracker=trim($_POST[tmip_visit_tracker_val]);
		if ($tmip_visit_tracker=='') {
			$tmip_visit_tracker=tmip_visit_tracker_default;
		}
		update_option(tmip_visit_tracker_val,$tmip_visit_tracker);

		$tmip_position=$_POST[tmip_position_val];
		if (($tmip_position != 'header') && ($tmip_position != 'footer')) {
			$tmip_position=tmip_position_default;
		}
		update_option(tmip_position_val, $tmip_position);
		
		$tmip_page_tracker=trim($_POST[tmip_page_tracker_val]);
		if ($tmip_page_tracker=='') {
			$tmip_page_tracker=tmip_page_tracker_default;
		}
		update_option(tmip_page_tracker_val,$tmip_page_tracker);
		
		$output .="<div class='tmip_alertGreen_div'><p>".tmip_service_Nname." settings have been updated!</p></div>";
	}


	$output .='<form method="post" action="options-general.php?page=TraceMyIP-Wordpress-Plugin.php">';
   	
	$output .=wp_nonce_field( 'update_tmip_visit_tracker_nonce', 'tmip_visit_tracker_nonce' );

	$output .='<div>';
	
	
	
	
	
	
	
	
	
	
	###### CHECK PROJECT CODE ###########################################################
	// Project code is not present
	if (!get_option(tmip_visit_tracker_val)) {
		$output .='<div class="tmip_alertRed_div">Your '.tmip_service_Dname.' plugin is active, but you have not entered your <b>['.tmip_lang_visitor_tr_code.'</b>] into the '.tmip_lang_visitor_tr_code.' input box. Refer to instructions provided below.</div>';
	
	// Project code contains page tracker code
	} elseif (get_option(tmip_visit_tracker_val) and strpos(get_option(tmip_visit_tracker_val),'tP_lanPTl') !== false) {
		$output .='<div class="tmip_alertRed_div">You have placed a [<b>'.tmip_lang_page_tr_code.'</b>] into the  '.tmip_lang_visitor_tr_code.' input box. Please place the '.tmip_lang_page_tr_code.' into the dedicated input box for '.tmip_lang_page_tr_code.'</div>';
	
	// Project code is not valid
	} elseif (get_option(tmip_visit_tracker_val) and strpos(get_option(tmip_visit_tracker_val),'rgtype=4684NR-IPIB')==false) {
		$output .='<div class="tmip_alertRed_div">The [<b>'.tmip_lang_visitor_tr_code.'</b>] you have entered is not a valid '.tmip_service_Dname.' code.</div>';
	}
	
	
	
	
	
	
	
	
	
	
	

	###### CHECK PAGE TRACKER CODE ###########################################################
	// Page tracker code contains visitor tracker code
	if (get_option(tmip_page_tracker_val) and strpos(get_option(tmip_page_tracker_val),'rgtype=4684NR-IPIB') !== false) {
		$output .='<div class="tmip_alertRed_div">You have placed a [<b>'.tmip_lang_visitor_tr_code.'</b>] into the '.tmip_lang_page_tr_code.' input box. Please place the '.tmip_lang_visitor_tr_code.' into the dedicated input box for '.tmip_lang_visitor_tr_code.'</div>';
	
	// Page Tracker code is not a JavaScript version of the code
	} elseif (get_option(tmip_page_tracker_val) and 
			(
				strpos(get_option(tmip_page_tracker_val),'echo') !== false or 
				strpos(get_option(tmip_page_tracker_val),'scr\"') !== false
			 )
		) {
		$output .='<div class="tmip_alertRed_div">The [<b>'.tmip_lang_page_tr_code.'</b>] you have entered is not a <b>JavaScript</b> version of the '.tmip_lang_page_tr_code.'. Use a <b>JavaScript</b> version of the <b>'.tmip_lang_page_tr_code.'</b> and place it into the '.tmip_lang_page_tr_code.' input box.</div>';
	
	// Page Tracker code is not valid
	} elseif (get_option(tmip_page_tracker_val) and strpos(get_option(tmip_page_tracker_val),'tP_lanPTl')==false) {
		$output .='<div class="tmip_alertRed_div">The [<b>'.tmip_lang_page_tr_code.'</b>] you have entered is not a valid '.tmip_service_Dname.' code. Generate a <b>JavaScript</b> version of the <b>'.tmip_lang_page_tr_code.'</b> and place it into the '.tmip_lang_page_tr_code.' input box.</div>';
	
	}
	
	
	
	
	
	
	
	###### ABOUT ###########################################################
	$output .='<h2>About '.tmip_service_Dname.'</h2>

        <blockquote>
		<h2 class="sec_title"><a href="'.tmip_home_page_url.'" target="_blank"><b>'.tmip_service_Dname.'</b></a> is a free and premium website tracking service that provides the following options to website publishers:</h2>
		<section>
		<ol class="tmip_sett_list_ol">
			<li><span>Full featured individual visitor <a href="'.tmip_home_page_url.'/website-analytics.htm" target="_blank">website statistics</a></span></li>
			<li><span>Visitor IP address, Visitor IP address changes and computer IDs tracking</span></li>
			<li><span>Visitor redirecting and blocking based on custom rules</span></li>
			<li><span>Mobile and desktop device targeting, redirection and browsing path control</span></li>
			<li><span>Individual real-time one-way message delivery to selected website visitors currently browsing a website</span></li>
			<li><span>Web page, links, document and contact forms protection, tracking and access control</span></li>
			<li><span>Integrated IP tracking data visitor control interface within WordPress dashboard</span></li>
			<li><span><b>FREE</b> & premium service <a href="'.tmip_premium_signup_page_url.'" target="_blank">subscriptions</a></span></li>
		</ol>
		</section>';
       
	   
	   
	###### TO ACTIVATE VISITOR TRACKING ###########################################################
	$output .='
		<h2 class="sec_title">To activate '.tmip_service_Dname.' tracking for WordPress, follow these steps:</h2>
		<section>
		<ol tmip_sett_list_ul>
            <li><span><a href="'.tmip_free_signup_page_url.'" target="_blank">Select a '.tmip_lang_visitr_track_ic.' style</a> and generate a <b>JavaScript</b> version of '.tmip_service_Dname.' '.tmip_lang_visitor_tr_code.'. Confirm your '.tmip_service_Dname.' account. If you already have a '.tmip_service_Dname.' account, simply login to your account and "Add a New Project" to generate a website '.tmip_lang_visitor_tr_code.' for your new WordPress website.</span></li>
			
            <li><span>Copy the '.tmip_lang_visitor_tr_code.' and paste it into the '.tmip_lang_visitor_tr_code.' input box below.</span></li>
			
			<li><span>Select the '.tmip_lang_tracker_icon_ps.' using the drop down menu below.</span></li>
			
			<li><span>Click on the '.tmip_lang_update_settings.' settings button below.</span></li>
			
			<li><span>First, verify that a '.tmip_lang_visitr_track_ic.' appears on <b>ALL</b> pages of your WordPress website. If you are a Level 2+ '.tmip_service_Dname.' subscriber, you can enable a hidden visitor tracking mode by clicking on the "edit" link located under your '.tmip_service_Dname.' account to the right of your project name.</span></li>
			<li><span>If you would like to control visitor access to your pages and send one-way messages to specific visitors, ensure that the Visitor Tracker code is installed properly and working, and then go to the Page Tracker menu within your project, generate a  '.tmip_lang_page_tr_code.' and place it into the '.tmip_lang_page_tr_code.' input box below.</span></li>
		</ol>
		</section>
		</blockquote>';




	###### VISITOR TRACKER AND PAGE TRACKER SETTINGS ###########################################################
	$output .='
		<h2 class="sec_title">'.tmip_service_Nname.' Settings</h2>
        <blockquote>
        <fieldset class="options">

            <table id="tmip_sett_area">
                <tr>
                    <td width="200">
                        <label for="'.tmip_visit_tracker_val.'" class="tmip_input_box_name">'.tmip_lang_visitor_tr_code.':</label>
						<br><div class="tmip_note">The '.tmip_lang_visitor_tr_code.' is used to track visitors and website stats.</div>
						<br><div class="tmip_tip_important">Use <b>JavaScript</b> '.tmip_lang_visitor_tr_code.' only.</div>
                    </td>
                    <td>
						<textarea id="'.tmip_visit_tracker_val.'" name="'.tmip_visit_tracker_val.'" onClick="tmip_select_all(\''.tmip_visit_tracker_val.'\');" class="tmip_textarea">'.stripslashes(get_option(tmip_visit_tracker_val)).'</textarea>
					</td>
                </tr>
                <tr>
                    <td>
                        <label for="'.tmip_position_val.'"><b>'.tmip_lang_tracker_icon_ps.':</b></label>
                    </td>
                    <td>';
					$output .='<select name="'.tmip_position_val.'" id="'.tmip_position_val.'">';
					$output .='<option value="header"';
					if (get_option(tmip_position_val)=="header") {
						$output .=' selected="selected"';
					}
					$output .='>Header</option>';

					$output .='<option value="footer"';
					if (get_option(tmip_position_val)=="footer") {
						$output .=' selected="selected"';
					}
					$output .='>Footer</option>';

					$output .='</select>';

 					$output .='
 					</td>
                </tr>
			   <tr>
                    <td width="200">
                        <label for="'.tmip_lang_page_tr_code.'" class="tmip_input_box_name">'.tmip_lang_page_tr_code.':</label>
						<br><div class="tmip_note">The '.tmip_lang_page_tr_code.' is used to send one-way messages to visitors and control their access to pages.</div>
						<br><div class="tmip_tip_important">Use <b>JavaScript</b> '.tmip_lang_page_tr_code.' only.</div>
                    </td>
                    <td>
						<textarea id="'.tmip_page_tracker_val.'" name="'.tmip_page_tracker_val.'" onClick="tmip_select_all(\''.tmip_page_tracker_val.'\');" class="tmip_textarea">'.stripslashes(get_option(tmip_page_tracker_val)).'</textarea>
					</td>
                </tr>
            </table>
        </fieldset>
        </blockquote>

        <p class="submit">
            <input type="submit" name="info_update" value="Update Settings" />
        </p>';

    $output .='</div>';
    $output .='</form>';

    $output .='</div>';

	echo $output;
}



// Add Page Tracker to header
add_action('wp_head','tmip_insert_page_tracker');

// Add Visitor Tracker to header or footer
$tmip_position=get_option(tmip_position_val);
if ($tmip_position=="header") {
	add_action('wp_head','tmip_insert_visitor_tracker');
} else {
	add_action('wp_footer','tmip_insert_visitor_tracker');
}


?>