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

 
include("view/header.php");
?>
<div style='background: url("components/com_extrawatch/img/backend.png"); height: 800px; border: 1px solid #ddd;'>
    <table width="300px" border="0" align="center">
        <tr><td colspan="2">
			<h2>Register here</h2>
            <h4>Start monitoring your website within 5 minutes</h4>
        </td></tr>
        <tr>
            <td width="100px" valign='top'>
                <img src="extrawatch/components/com_extrawatch/img/icons/extrawatch-logo-48x48.png"/>
            </td>
            <td width="200px">
                <form action="sendmail.php" method="POST">
                    <table width="200px" border="0">
                        <tr><td>Email: </td><td><input type="text" name="email"  value="@"/></td></tr>
                        <tr><td></td></tr>
                        <tr><td>URL: </td><td><input type="text" name="urlToMonitor"  value="http://"/></td></tr>
                        <tr><td></td></tr>
                        <tr><td></td><td><input type="submit" name="Login" value="Start now" style='background-color: green; color: white; font-weight: bold; font-size: 18px'/></td></tr>
                        <input type="hidden" name="action" value="login"/>
                    </table>
                </form>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
				<br/><br/>
                <i>
                    After entering your email a HTML code will be sent to your email,
                    which you need to include to your website.
                    This is a 30-day trial of PRO version. All emails are private according to our privacy policy.
                </i>
            </td>
        </tr>
    </table>

</div>