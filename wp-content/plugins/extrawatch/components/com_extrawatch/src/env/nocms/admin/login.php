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
	width:100px;
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
<center>
    <table width="300px" border="0" align="center" cellpadding='10' cellspacing='10' valign='top'>
        <tr><td colspan="2">
            <h2>Login form</h2>
			<br/><br/>
        </td></tr>
        <tr>
            <td width="300px">
				<i>If you don't know the password, please check your email from extrawatch.com. In case of any other problems, contact us via live chat in lower right corner.</i>
				<br/><br/>
                <form action="" method="POST">
                    <table width="300px" border="0">
                        <tr><td>Email: &nbsp;&nbsp;</td><td><input type="text" name="email"  value="<?php echo @$_SESSION['email'];?>" style='border: 1px solid #dddddd'/> <br/><br/></td></tr>
                        <tr><td></td></tr>
                        <tr><td>Password: &nbsp;&nbsp;</td><td><input type="password" name="password" value="<?php echo @$_SESSION['password'];?>"  style='border: 1px solid #dddddd'/><br/><br/></td></tr>
                        <tr><td></td></tr>
                        <tr><td></td><td><input type="submit" name="Login" value="Login"  style='font-weight: bold; font-size: 16px;'/></td></tr>
                        <input type="hidden" name="action" value="login"/>
						<tr>
						<td></td><td>
						<br/>
										<a href='register.php' style='color: blue; text-decoration: none;'>No account yet? Register here</a>

						</td>
						</tr>
                    </table>
                </form>
				<br/><br/>
            </td>
        </tr>
    </table>
</center>
</div>