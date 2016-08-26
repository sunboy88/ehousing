<?php
/**
 * @file
 * ExtraWatch - A real-time ajax monitor and live stats
 * @package ExtraWatch
 * @version 2.2
 * @revision 123
 * @license http://www.gnu.org/licenses/gpl-3.0.txt     GNU General Public License v3
 * @copyright (C) 2013 by CodeGravity.com - All rights reserved!
 * @website http://www.codegravity.com
 */

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr" >
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="Super User" />
    <title>Real-time live stats for Joomla, Wordpress, Drupal, Magento and PrestaShop</title>
    <script type='text/javascript'> var jax = jQuery.noConflict();
    jax(document).ready( function()	{jax('#ftestimonial').innerfade({ animationtype: 'fade', speed: 2000, timeout: 5000, type: 'sequence',containerheight:'200px' });} );
    </script>
    <!--[if lte IE 6]>
    <link href="http://www.extrawatch.com/templates/extra_watch/css/ieonly.css" rel="stylesheet" type="text/css" />
    <![endif]-->

    <!--[if IE 7]>
    <link href="http://www.extrawatch.com/templates/extra_watch/css/ie7only.css" rel="stylesheet" type="text/css" />
    <![endif]-->

    <script type="text/javascript" src="http://www.extrawatch.com/templates/extra_watch/js/jquery.js"></script>
    <script type="text/javascript" src="http://www.extrawatch.com/templates/extra_watch/js/scripts.js"></script>
    <script type="text/javascript" src="http://www.extrawatch.com/templates/extra_watch/js/combined.js"></script>
	
<style>
.headerSec{ width:100%; float:left; background:url(/view/img/header_bg.jpg) repeat-x 0 0;}
.headerMain{ width:100%;  margin:0; padding:0; float:left; background:url(/view/img/globe-top.png) no-repeat right; height: 150px;}
.header_lft{ width:780px; float:left; margin:0px 0 0 0; padding:0;}
.header_lft img{ float:left; width:130px; height:132px; margin-right:22px;}
.header_lft strong{ color:#252525; font-family: 'Helvetica'; font-size:48px; font-weight:normal; float:left; margin-top:20px;}
.header_lft strong sup{font-family: 'MyriadPro-Semibold'; font-size:20px; color:#252525;}
.header_lft span{ font-family: 'Helvetica'; font-weight:normal; font-size:22px; color:#202020; float:left; margin-top:5px;}

HTML {padding-left: 20px; padding-right: 20px;}

table {
border-collapse: separate;
border-color: gray;
}

</style>	
	
</head>

<body>
<?php 

if (@$_GET['hideHeader']) {
	@$_SESSION['hideHeader'] = 1;
}
$hideHeader = @$_SESSION['hideHeader'];

if (!$hideHeader) { ?>

<table width='100%'>
<tr>
<td>
<div class="wrapper">
    <div class="headerSec">
        <div class="headerMain" style='width: 100% !important'>
            <div class="main">
                <div class="header_lft">
                    <table><tr>
                        <td>
                            <a href="http://stats.extrawatch.com/"><img src="view/img/logo.png" alt=" " /></a>
                        </td>
                        <td style="height: 90px;width:350px;">
                            <strong><a href='http://www.extrawatch.com' style='color: black'>ExtraWatch</a><sup>TM</sup></strong>
                            <span>Live visitor conversion tracking, Counter, Anti-spam, Heatmap, SEO</span><br/>
                            <span style='font-size:14px'><i>Hosted service with data in cloud</i></span>
                        </td>
						<td style='padding-left: 20px;'>
						<?php /*
						if (@$_SESSION['email']) { 
						?>
						<br/><br/>
						<h4 style='color: red'>This is a trial version, please subscribe. <br/>
Special start-up promo: Only 1,99&nbsp;&euro;/month</h4>							
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="custom" value="<?php echo _EW_PROJECT_ID;?>">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
						<?php 
							}
							*/
						?>

						</td>
                    </tr>
                    </table>
                </div>
		             <div class="header_rht">
					</div>

            </div>
        </div>
    </div>
</div>

</td>
</tr>
</table>
<?php } ?>

<!--
<br/><br/>
&nbsp;
<br/><br/>
<div style='border: 1px solid red; width:100%; text-align: center'>
Notice: Due to a maintenance, visits from 09.09.2013 and 10.09.2013 were not properly recorded. We apologize for this, it was caused to an update to newer version. Thank you for your understanding.
</div>
-->          
<br/>
<!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
	window.__insp = window.__insp || [];
	__insp.push(['wid', 503133643]);
	(function() {
		function __ldinsp(){var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://www.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); }
		if (window.attachEvent){
			window.attachEvent('onload', __ldinsp);
		}else{
			window.addEventListener('load', __ldinsp, false);
		}
	})();
</script>
<!-- End Inspectlet Embed Code -->