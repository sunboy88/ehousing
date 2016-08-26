<?php

require("../../ExtraWatchGUITestBase.php");

class ExtraWatchLoginTest extends ExtraWatchGUITestBase {

  public function testLoginOptions() {
	  $this->url('http://localhost');
	  $this->assertRegExp('/Login/i', $this->source());
	  $this->assertRegExp('/Create an account/i', $this->source());
	  $this->assertRegExp('/Forgot your username/i', $this->source());
	  $this->assertRegExp('/Forgot your password/i', $this->source());	  
  }
  
  /**
     * @depends testLoginOptions
     */
  public function testInvalidLogIn() {
    $this->url('http://localhost/');
	
	$form = $this->byCssSelector('form');
	$action = $form->attribute('id');
	$this->assertEquals('login-form',$action);
	
	$this->assertTag(array('id' => 'modlgn-username'), $this->source()); 
	$this->assertTag(array('id' => 'modlgn-passwd'), $this->source());
	
	$username = $this->byId('modlgn-username');
	$password = $this->byId('modlgn-passwd');
	
	$username->value('invalid');
	$password->value('invalid');
	$form->submit();
	
	$warning = $this->byCssSelector('h4')->text();
	$this->assertRegExp('/Warning/i',$warning);
	//next page
	$form = $this->byCssSelector('form');
	$action = $form->attribute('class');
	$this->assertEquals('form-horizontal',$action);
	
	$this->assertTag(array('id' => 'username'), $this->source()); 
	$this->assertTag(array('id' => 'password'), $this->source());
	
	$username = $this->byId('username');
	$password = $this->byId('password');
	//clear set fields
	$username->clear();
	$password->clear();
	
	$username->value('invalid');
	$password->value('invalid');
	$form->submit();
	
	$this->assertRegExp('/Warning/i',$warning);
  }
  
  /**
     * @depends testLoginOptions
     */
  public function testValidLogin() {
	  
	$this->url('http://localhost/');
	$form = $this->byCssSelector('form');
	$action = $form->attribute('id');
	$this->assertEquals('login-form',$action);
	
	$this->byId('modlgn-username')->value('ondrejlenka');
	$this->byId('modlgn-passwd')->value('wilex1');
	$form->submit();
	  
	$this->assertRegExp('/Site Administrator/i', $this->source());	
	$this->byLinkText('Site Administrator')->click();
  }
}