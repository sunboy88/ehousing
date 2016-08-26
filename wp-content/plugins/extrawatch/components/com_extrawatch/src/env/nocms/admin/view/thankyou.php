<style>
BODY {
	background: url(/view/img/header_bg.jpg)
}
@font-face {
  font-family: 'Cabin';
  font-style: normal;
  font-weight: 400;
  src: local('Cabin Regular'), local('Cabin-Regular'), url(http://www.extrawatch.com/templates/extra_watch/fonts/cabin.woff) format('woff');
}
DIV {
	font-family: Cabin;
}
.logInButton {
	-moz-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	-webkit-box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	box-shadow:inset 0px 1px 0px 0px #c1ed9c;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #9dce2c), color-stop(1, #8cb82b) );
	background:-moz-linear-gradient( center top, #9dce2c 5%, #8cb82b 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#9dce2c', endColorstr='#8cb82b');
	background-color:#9dce2c;
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
	font-family:Arial;
	font-size:15px;
	font-weight:bold;
	font-style:normal;
	height:40px;
	line-height:40px;
	width:450px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #689324;
}
.logInButton:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #8cb82b), color-stop(1, #9dce2c) );
	background:-moz-linear-gradient( center top, #8cb82b 5%, #9dce2c 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#8cb82b', endColorstr='#9dce2c');
	background-color:#8cb82b;
}.logInButton:active {
	position:relative;
	top:1px;
}
</style>
<div style='background: url("extrawatch/components/com_extrawatch/img/backend.png"); height: 800px; border: 1px solid #ddd;'>
<br/><br/>&nbsp;<br/><br/>

<center>

<h2>Thank you for your registration, this is your tracking code:</h2>
<textarea cols='100' rows='6'>
<?php echo($htmlCodeSnippet);?>
</textarea>
<br/>
<span style='color: #C20808'>
<b>1. Please copy and paste this tracking code to every page you want to track. <br/>
If you need help with this, contact us via live chat in lower right corner</b>
</span>

<br/>
<br/>
<i>A copy of this code was also sent to your email address. </i><br/>


<br/>
2. After including the HTML code to every page you want to track<br/><br/>
<a href='http://stats.extrawatch.com' class='logInButton'>I have installed my tracking code and I want to Log in</a> <br/><br/>
to see your live stats and heatmaps
</center>
</div>

<?php 	include("livechat.php"); ?>
