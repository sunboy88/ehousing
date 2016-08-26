<?php

   // Send an empty HTTP 200 OK response to acknowledge receipt of the notification 
   header('HTTP/1.1 200 OK'); 
  

  // Assign payment notification values to local variables
  $item_name        = @$_POST['item_name'];
  $item_number      = @$_POST['item_number'];
  $payment_status   = @$_POST['payment_status'];
  $payment_amount   = @$_POST['mc_gross'];
  $payment_currency = @$_POST['mc_currency'];
  $txn_id           = @$_POST['txn_id'];
  $receiver_email   = @$_POST['receiver_email'];
  $payer_email      = @$_POST['payer_email'];
  $custom      = @$_POST['custom'];	//project Id
  


 
 function activateLicenseForProjectId($projectId) {

    define('_JEXEC',1);

	define("DS","/");
	define("ENV",1);
	define("JPATH_BASE2",dirname(__FILE__).DS."..".DS."extrawatch");

	require_once ("..".DS."connection.php");
	require_once ("..".DS."extrawatch".DS."components".DS."com_extrawatch".DS."config.php");
	require_once ("..".DS."extrawatch".DS."components".DS."com_extrawatch".DS."src".DS."inc.extrawatch.env.php");
	require_once ("..".DS."extrawatch".DS."components".DS."com_extrawatch".DS."includes.php");

	$env = ExtraWatchEnvFactory::getEnvironment();
	$database = $env->getDatabase("");

	$query = sprintf("update global_extrawatch_project set active = 1, lastPayment = %d where id = %d ", (int) time(), (int) $projectId);
	$database->executeQuery($query);

} 
  
//Use the notification to build the acknowledgement message required by the IPN authentication protocol.
  // Build the required acknowledgement message out of the notification just received
  $req = 'cmd=_notify-validate';               // Add 'cmd=_notify-validate' to beginning of the acknowledgement

  foreach ($_POST as $key => $value) {         // Loop through the notification NV pairs
    $value = urlencode(stripslashes($value));  // Encode these values
    $req  .= "&$key=$value";                   // Add the NV pairs to the acknowledgement
  }
//Post the acknowledgement back to PayPal, so PayPal can determine whether the original notification was tampered with.
  // Set up the acknowledgement request headers
  $header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";                    // HTTP POST request
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

  // Open a socket for the acknowledgement request
  $fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

  // Send the HTTP POST request back to PayPal for validation
  fputs($fp, $header . $req);
//Parse PayPal's response to your acknowledgement to determine whether the original notification was OK - if so, process it.
  while (!feof($fp)) {                     // While not EOF
    $res = fgets($fp, 1024);               // Get the acknowledgement response
    if (strcmp ($res, "VERIFIED") == 0) {  // Response contains VERIFIED - process notification

      // Send an email announcing the IPN message is VERIFIED
      $mail_From    = "foo@codegravity.com";
      $mail_To      = "foo@codegravity.com";
      $mail_Subject = "VERIFIED IPN";
      $mail_Body    = $req;
      mail($mail_To, $mail_Subject, $mail_Body, $mail_From);

		if (@$custom) {
			activateLicenseForProjectId($custom);
			mail($mail_To, "subscription prolonged for project id: $custom", $mail_Body, $mail_From);
		}  
	  

	  
      // Authentication protocol is complete - OK to process notification contents

      // Possible processing steps for a payment include the following:

      // Check that the payment_status is Completed
      // Check that txn_id has not been previously processed
      // Check that receiver_email is your Primary PayPal email
      // Check that payment_amount/payment_currency are correct
      // Process payment

    } 
    else if (strcmp ($res, "INVALID") == 0) { // Response contains INVALID - reject notification

      // Authentication protocol is complete - begin error handling

      // Send an email announcing the IPN message is INVALID
      $mail_From    = "foo@codegravity.com";
      $mail_To      = "foo@codegravity.com";
      $mail_Subject = "INVALID IPN";
      $mail_Body    = $req;

      mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
    }
  }
//Close the file and end the PHP script.

  fclose($fp);  // Close the file
  
  
  