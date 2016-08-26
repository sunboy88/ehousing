<?php

session_start();

define("DS","/");
define("_JEXEC",1);
define("ENV",1);
define("JPATH_BASE2",dirname(__FILE__).DS."extrawatch");
$path = realpath(".").DS."extrawatch";

require_once ("extrawatch".DS."components".DS."com_extrawatch".DS."config.php");
require_once ("extrawatch".DS."components".DS."com_extrawatch".DS."src".DS."inc.extrawatch.env.php");

require_once($path. DS. "components" . DS . "com_extrawatch" . DS . "includes.php");
require_once($path. DS. "administrator" . DS . "components" . DS . "com_extrawatch" . DS . "install.extrawatch.php");

$env = ExtraWatchEnvFactory::getEnvironment();
$database = $env->getDatabase("");

$email = $_POST['email'];
$url = $_POST['urlToMonitor'];
$action = $_POST['action'];

require_once("ClassMathGuard.php");

include("view/header.php");

$isCorrectAnswer = MathGuard :: checkResult(@$_REQUEST['mathguard_answer'], @$_REQUEST['mathguard_code']);

if ($action == 'formSubmitted' && !$isCorrectAnswer) {
	echo("<center><span style='color: red'>Wrong security answer!</span></center>");
}

if ($action != 'formSubmitted' || !$isCorrectAnswer) {
?>

<style>
@font-face {
  font-family: 'Cabin';
  font-style: normal;
  font-weight: 400;
  src: local('Cabin Regular'), local('Cabin-Regular'), url(http://www.extrawatch.com/templates/extra_watch/fonts/cabin.woff) format('woff');
}

TABLE {
	font-family: Cabin;
}

.finishRegButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	-webkit-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #7fbc29), color-stop(1, #8cb82b) );
	background:-moz-linear-gradient( center top, #7fbc29 5%, #8cb82b 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#7fbc29', endColorstr='#8cb82b');
	background-color:#7fbc29;
	-webkit-border-top-left-radius:0px;
	-moz-border-radius-topleft:0px;
	border-top-left-radius:0px;
	-webkit-border-top-right-radius:0px;
	-moz-border-radius-topright:0px;
	border-top-right-radius:0px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0;
	border:1px solid #83c41a;
	display:inline-block;
	color:#ffffff;
	font-family:Cabin;
	font-size:16px;
	font-weight:bold;
	font-style:normal;
	height:42px;
	line-height:42px;
	width:250px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #689324;
}
.finishRegButton:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8cb82b), color-stop(1, #7fbc29) );
	background:-moz-linear-gradient( center top, #8cb82b 5%, #7fbc29 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8cb82b', endColorstr='#7fbc29');
	background-color:#8cb82b;
}.finishRegButton:active {
	position:relative;
	top:1px;
}

BODY {
	background: url(/view/img/header_bg.jpg)
}

</style>
<center>
<table>
<tr>
<td>


<table align='center'><tr><td>
	<form action="sendmail.php" method='POST'>
	<h2>Please finish your registration</h2>
	to understand your visitors better (data stored in cloud)<br/><br/>
	
	<i style='font-size: 14px'>
	In order to use the service, you need to have an access<br/>
	to edit the HTML source codes of your website  <br/>
	to be able to insert the HTML code tracking code.</i><br/><br/>

	<span style='color: #BB2525'>If you're looking for installable plug-in and not the hosted tracking with data in cloud, <br/>
	please visit our <a href='http://www.extrawatch.com/downloads' style='color: #BB2525'>downloads section</a></span><br/><br/>
	

	<i style='font-size: 14px'>After you confirm the security question, this tracking code will be <br/>
	emailed to you, and you need to place it to your website's template</i><br/><br/>

	<i style='font-size: 14px'>Try our heatmaps, conversion tracking without any obligation</i><br/><br/>
	
	<b>email:</b> <?php echo $_POST['email']; ?> <br/><br/>
	<b>url:</b> <?php echo $_POST['urlToMonitor']; ?><br/><br/>

	<input type='hidden' name='email' value='<?php echo $_POST['email']; ?>'/>
	<input type='hidden' name='urlToMonitor' value='<?php echo @$_POST['urlToMonitor']; ?>'/>
	<input type='hidden' name='action' value='formSubmitted'/>
	<?php
	MathGuard::insertQuestion();
	?>
	<br/>
	By continuing with registration process, you agree to our <a href='view/terms.html' target='_blank'>terms &amp; conditions</a>
	<br/><br/>

<!--	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="custom" value="<?php echo $_POST['email']; ?>;<?php echo $_POST['urlToMonitor']; ?>">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
-->
	<input type='submit' name='button' value='Get my tracking code now' class='finishRegButton'/>
<!-- <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
-->


	</td>
	</tr>
</table>
</td>
<td style='padding-left: 30px'>
	<iframe id="video-player" width="500" height="333" src="http://www.youtube.com/embed/OELeZHt8kbE?enablejsapi=1&autoplay=0&rel=0&modestbranding=1&showinfo=0&showsearch=0&vq=hd1080" frameborder="0" allowfullscreen></iframe>

</td>
</tr>
</table>
</center>


<?php 
die();
}


if (!$url || !$email) {
	die("not enough parameters");
}



$id = $database->resultQuery(sprintf("select id from global_extrawatch_user where email = ('%s')  ", $email));
if (!@$id) {
	$generatedPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789') , 0 , 6 );
	$result = $database->executeQuery(sprintf("insert into global_extrawatch_user (`email`, `password`) values ('%s', '%s')  ", $email, $generatedPassword));

	$userId = $database->resultQuery(sprintf("select max(id) from global_extrawatch_user where email = '%s' ", $email));
	$result = $database->executeQuery(sprintf("insert into global_extrawatch_project (userId, url) values ('%s','%s')  ", $userId, $url));
	$projectId = $database->resultQuery(sprintf("select max(id) from global_extrawatch_project where userId = '%d' ", $userId));

} else {
//	echo("user $email already found, resending email");
//	die();
	$userId = $id;
}




$extraWatch = new ExtraWatchMain();

$body = "Welcome user $email <br/> your password is: $generatedPassword<br/><br/><br/>";

$htmlCodeSnippet = htmlentities($extraWatch->helper->renderHTMLCodeSnippet($projectId));
$body .= "Please include the followith HTML code: <br/>";
$body .= nl2br($htmlCodeSnippet);

$body .= "<br/>To check your stats, please use the login information above to log into: <a href='http://stats.extrawatch.com'>stats.extrawatch.com</a>";


ExtraWatchHelper::sendEmail(ExtraWatchEnvFactory::getEnvironment(), $email, "info@extrawatch.com","ExtraWatch HTML code to monitor your website $url",$body, "info@codegravity.com");

include("view/thankyou.php");


