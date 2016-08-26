<?php

require("../../ExtraWatchGUITestBase.php");

class ExtraWatchLoginTest extends ExtraWatchGUITestBase {

  /** 
     * @param string $id - DOM id
     * @param int $wait - maximum (in seconds)
     * @retrn element|false - false on time-out
     */ 
	protected function waitForCssSelector($selector, $wait=30) { 
	  for ($i=0; $i <= $wait; $i++) { 
		try{ 
		  $x = $this->byCssSelector($selector); 
		  return $x; 
		} 
		catch (Exception $e) { 
		  sleep(1); 
		} 
	  } 
	  return false; 
	} 
  
  public function testLoginOptions() {
	  $this->url(self::WP_PATH.'/wp-login.php');
	  $this->assertRegExp('/Login/i', $this->source());
	  $this->assertRegExp('/Lost your password?/i', $this->source());
  }
  
  /**
     * @depends testLoginOptions
     */
  public function testInvalidLogIn() {
    $this->url(self::WP_PATH.'/wp-login.php');
	
	$form = $this->byCssSelector('#loginform');
	
	$this->assertTag(array('id' => 'user_login'), $this->source()); 
	$this->assertTag(array('id' => 'user_pass'), $this->source());
	
	$username = $this->byId('user_login');
	$password = $this->byId('user_pass');
	
	$username->value('invalid');
	$password->value('invalid');
	$form->submit();
	
	$warning = $this->byCssSelector('#login_error')->text();
	$this->assertRegExp('/Invalid username/i',$warning);
	//next page
	$form = $this->byCssSelector('#loginform');
	
	$username = $this->byId('user_login');
	$password = $this->byId('user_pass');
	//clear set fields
	$username->clear();
	$password->clear();
	
	$username->value('demo');
	$password->value('invalid');
	$form->submit();
	
	$warning = $this->byCssSelector('#login_error')->text();
	$this->assertRegExp('/The password you entered/i',$warning);
  }
  
  /**
     * @depends testLoginOptions
     */
  public function testValidLogin() {
	  
	$this->url(self::WP_PATH.'/wp-login.php');
	$form = $this->byCssSelector('#loginform');
	
	$username = $this->byId('user_login');
	$password = $this->byId('user_pass');
	
	$username->clear();
	$password->clear();
	
	$username->value('demo');
	$password->value('demo');
	$form->submit();
	  
	$this->waitForCssSelector('h2', 20);
	$this->assertRegExp('/Dashboard/i', $this->source());	
  }
}