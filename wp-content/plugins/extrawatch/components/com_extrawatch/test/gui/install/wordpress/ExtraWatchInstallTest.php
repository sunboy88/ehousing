<?php

require("../../ExtraWatchGUITestBase.php");

class ExtraWatchInstallTest extends ExtraWatchGUITestBase {


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

	public function testlanguage() {
	  $this->url(self::WP_PATH.'/wp-admin/admin.php?page=extrawatch&task=settings&action=');
	  //second login
	  $this->waitForCssSelector('#loginform', 10);
	  $form = $this->byCssSelector('#loginform');
	  $username = $this->byId('user_login');
	  $password = $this->byId('user_pass');
	
	  $username->clear();
	  $password->clear();
	
	  $username->value('demo');
	  $password->value('demo');
	  $form->submit();
	  //admin page
	  $this->assertContains('WordPress', $this->title());
	  // set English language
	  $settingsForm = $this->byId('settingsForm');
	  $this->select($this->byId('EXTRAWATCH_LANGUAGE'))->selectOptionByLabel('english');
	  $selectedOption = $this->select($this->byId('EXTRAWATCH_LANGUAGE'))->selectedLabel();
	  $this->assertEquals('english', $selectedOption);
	  $settingsForm->submit();
	}
	/*
	public function testsetKeepData() {
	  $this->url(self::WP_PATH.'/wp-admin/admin.php?page=extrawatch&task=settings&action=');
	  //second login
	  $this->waitForCssSelector('#loginform', 10);
	  $form = $this->byCssSelector('#loginform');
	  $username = $this->byId('user_login');
	  $password = $this->byId('user_pass');
	
	  $username->clear();
	  $password->clear();
	
	  $username->value('demo');
	  $password->value('demo');
	  $form->submit();
	  //admin page
	  $this->assertContains('WordPress', $this->title());
	  $this->waitForCssSelector('h3', 20);
	  $advanced = $this->byXPath('/html/body/div/div[3]/div[2]/div/div[3]/center/form/div/div[3]/ul/li[5]/a')->click();
	  $this->waitForCssSelector('h3', 20);
	  $settingsForm = $this->byId('settingsForm');
	  $this->waitForCssSelector('#EXTRAWATCH_UNINSTALL_KEEP_DATA', 20);
	  $selectBox = $this->byXPath('//*[@id="EXTRAWATCH_UNINSTALL_KEEP_DATA"]');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  $settingsForm->submit();
	} */

	public function testuninstall() {
	  $this->url(self::WP_PATH.'/wp-admin/plugins.php');
	  //second login
	  $this->waitForCssSelector('#loginform', 10);
	  $form = $this->byCssSelector('#loginform');
	  $username = $this->byId('user_login');
	  $password = $this->byId('user_pass');
	
	  $username->clear();
	  $password->clear();
	
	  $username->value('demo');
	  $password->value('demo');
	  $form->submit();
	  
	  //admin page go to extention manager
	  $this->assertContains('Plugins', $this->title());	
	  
	  //deactive modules    
	  $this->waitForCssSelector('tr#extrawatch-live-stats-and-visitor-counter-pro.active th.check-column input', 10);
	  $selectBox = $this->byCssSelector('tr#extrawatch-live-stats-and-visitor-counter-pro.active th.check-column input');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  
	  $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectOptionByLabel('Deactivate');
	  $selectedOption = $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectedLabel();
	  $this->assertEquals('Deactivate', $selectedOption);
	  $this->byId('doaction')->click();
	  $this->waitForCssSelector('div#message.updated p strong', 10);
	  $this->assertEquals('deactivated', $this->byCssSelector('div#message.updated p strong')->text());
	
	  //uninstall modules
	  $selectBox = $this->byCssSelector('tr#extrawatch-live-stats-and-visitor-counter-pro.inactive th.check-column input');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  
	  $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectOptionByLabel('Delete');
	  $selectedOption = $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectedLabel();
	  $this->assertEquals('Delete', $selectedOption);
	  $this->byId('doaction')->click();
	  $this->waitForCssSelector('h2', 10);
	  $this->assertContains('Delete Plugin', $this->byCssSelector('h2')->text());
	  $this->byId('submit')->click();
	  $this->waitForCssSelector('#message.updated p strong', 10);
	  $this->assertContains('deleted', $this->byCssSelector('#message.updated p strong')->text());
	}
	
	/**
     * @depends testuninstall
     */ 
	public function testreinstall() { 
	  $this->url(self::WP_PATH.'/wp-admin/plugin-install.php');
	  //second login
	  $this->waitForCssSelector('#loginform', 10);
	  $form = $this->byCssSelector('#loginform');
	  $username = $this->byId('user_login');
	  $password = $this->byId('user_pass');
	
	  $username->clear();
	  $password->clear();
	
	  $username->value('demo');
	  $password->value('demo');
	  $form->submit();
	  
	  $this->waitForCssSelector('h2', 10);
	  $this->assertContains('Install Plugins', $this->byCssSelector('h2')->text());
	  
	  // install section -> from search
	  $this->waitForCssSelector('#search-plugins', 10);
	  $form = $this->byCssSelector('#search-plugins');
	  $search = $this->byXPath('/html/body/div/div[3]/div[2]/div/div[4]/form/input[2]');
 	  $search->clear();
	  $search->value('extrawatch pro'); 
	  $form->submit();
	  $this->waitForCssSelector('a.install-now', 10);
	  $this->byLinkText('Install Now')->click();
	  
	  // accept the pop up
	  $this->acceptAlert();
  
	  // confirm successful install
	  $this->waitForCssSelector('div#wpbody-content div.wrap p strong', 10);
	  $this->assertContains('Successfully installed the plugin ', $this->source()); 
	  
	  // activate plug in
	  $this->url(self::WP_PATH.'/wp-admin/plugins.php');
	  $selectBox = $this->byCssSelector('tr#extrawatch-live-stats-and-visitor-counter-pro.inactive th.check-column input');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  
	  $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectOptionByLabel('Activate');
	  $selectedOption = $this->select($this->byCssSelector('div#wpbody-content div.wrap form div.tablenav div.alignleft select'))->selectedLabel();
	  $this->assertEquals('Activate', $selectedOption);
	  $this->byId('doaction')->click();
	  
	  // check activation
	  $this->waitForCssSelector('div#message.updated p strong', 10);
	  $this->assertEquals('activated', $this->byCssSelector('div#message.updated p strong')->text()); 
	}
	
	/**
     * @depends testreinstall
     */ 
	public function testfinnishinstall() {
		
	  $this->url(self::WP_PATH.'/wp-admin/admin.php?page=extrawatch');
	  //second login
	  $this->waitForCssSelector('#loginform', 10);
	  $form = $this->byCssSelector('#loginform');
	  $username = $this->byId('user_login');
	  $password = $this->byId('user_pass');
	
	  $username->clear();
	  $password->clear();
	
	  $username->value('demo');
	  $password->value('demo');
	  $form->submit();
	  
	  $this->waitForCssSelector('#accept', 10);
	  
	  // finis install
	  $selectBox = $this->byId('accept');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  $this->byId('continue')->click();
	  
	  //enter registration code
	  $this->waitForCssSelector('td form', 10);
	  $form = $this->byCssSelector('div#wpbody-content div.wrap table tbody tr td table tbody tr td table tbody tr td form');
	  $code = $this->byXPath('/html/body/div/div[3]/div[2]/div/div[3]/table/tbody/tr/td/table/tbody/tr/td/table/tbody/tr/td/form/input');
 	  $code->clear();
	  $code->value('9812b7baedca0fe3b1eb154399823f44'); 
	  $form->submit();
	} 
}
?>