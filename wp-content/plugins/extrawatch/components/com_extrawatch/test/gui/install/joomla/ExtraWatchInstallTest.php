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
	  $this->url(self::JOOMLA_PATH.'/administrator/index.php?option=com_extrawatch&task=settings&action=');
	  //second login
	  $this->waitForCssSelector('form', 10);
	  $form = $this->byCssSelector('form');
	  $action = $form->attribute('id');
	  $this->assertEquals('form-login',$action);
  
	  $this->byId('mod-login-username')->value('demo');
	  $this->byId('mod-login-password')->value('demo');
	  $form->submit();
	  //admin page
	  $this->assertContains('Administration', $this->title());
	  // set English language
	  $settingsForm = $this->byId('settingsForm');
	  $this->select($this->byId('EXTRAWATCH_LANGUAGE'))->selectOptionByLabel('english');
	  $selectedOption = $this->select($this->byId('EXTRAWATCH_LANGUAGE'))->selectedLabel();
	  $this->assertEquals('english', $selectedOption);
	  $settingsForm->submit();
	}
	/*
	public function testsetKeepData() {
	  $this->url(self::JOOMLA_PATH.'/administrator/index.php?option=com_extrawatch&task=settings&action=#5');
	  //second login
	  $this->waitForCssSelector('form', 10);
	  $form = $this->byCssSelector('form');
	  $action = $form->attribute('id');
	  $this->assertEquals('form-login',$action);
  
	  $this->byId('mod-login-username')->value('ondrejlenka');
	  $this->byId('mod-login-password')->value('wilex1');
	  $form->submit();
	  //admin page
	  $this->assertContains('Administration', $this->title());
	  $this->waitForCssSelector('#settingsForm', 20);
	  $settingsForm = $this->byId('settingsForm');
	  $this->waitForCssSelector('#EXTRAWATCH_UNINSTALL_KEEP_DATA', 20);
	  $selectBox = $this->byId('EXTRAWATCH_UNINSTALL_KEEP_DATA');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  $settingsForm->submit();
	} 
	*/
	public function testuninstall() {
	  $this->url(self::JOOMLA_PATH.'/administrator/');
	  //second login
	  $this->waitForCssSelector('form', 10);
	  $form = $this->byCssSelector('form');
	  $action = $form->attribute('id');
	  $this->assertEquals('form-login',$action);
  
	  $this->byId('mod-login-username')->value('demo');
	  $this->byId('mod-login-password')->value('demo');
	  $form->submit();
	  
	  //admin page go to extention manager
	  $this->assertContains('Administration', $this->title());	
	  $this->byLinkText('Extensions')->click();
	  $this->byLinkText('Extension Manager')->click(); 
	  $this->waitForCssSelector('#submenu', 20);
	  $this->byLinkText('Manage')->click(); 
	  $this->waitForCssSelector('#submenu', 20);
	  $this->assertContains('Extension Manager: Manage', $this->source());
	  
	  //search for ExtraWatch modules
	  $form = $this->byCssSelector('form');
	  $action = $form->attribute('id');
	  $this->assertEquals('adminForm',$action);
	  $this->byId('filter_search')->value('extrawatch');
	  $form->submit();
	  
	  //select all modules
	  $selectBox = $this->byCssSelector('div#j-main-container.span10 table.table thead tr th input');
	  $this->assertFalse($selectBox->selected());
	  $selectBox->click();
	  
	  //uninstall modules
	  $this->byCssSelector('div#toolbar-delete.btn-group button.btn')->click();
	} 
	/**
     * @depends testuninstall
     */
	public function testreinstall() {
	  $this->url(self::JOOMLA_PATH.'/administrator/');
	  //second login
	  $this->waitForCssSelector('form', 10);
	  $form = $this->byCssSelector('form');
	  $action = $form->attribute('id');
	  $this->assertEquals('form-login',$action);
  
	  $this->byId('mod-login-username')->value('demo');
	  $this->byId('mod-login-password')->value('demo');
	  $form->submit();
	  
	  //admin page -> go to extention manager
	  $this->assertContains('Administration', $this->title());	
	  $this->byLinkText('Extensions')->click();
	  $this->byLinkText('Extension Manager')->click(); 
	  $this->waitForCssSelector('#submenu', 20);
	  
	  /*
	  // go to install section -> from url
	  $this->byLinkText('Install from URL')->click();
	  $this->byId('install_url')->clear();
	  //enter full directory path!!!
	  $this->byId('install_url')->value('http://www.extrawatch.com/download/PRO/version-2.2-beta/Joomla-1.6-1.7-2.5-3.0/pkg_ExtraWatch-Joomla-1.6-1.7-2.5-3.0.zip');
	  $this->byCssSelector('div#url.tab-pane fieldset.uploadform div.form-actions input.btn')->click(); 
	  */
	  
	  // go to install section -> from directory
	  $this->byLinkText('Install from Directory')->click();
	  $this->byId('install_directory')->clear();
	  //enter full directory path!!!
	  $this->byId('install_directory')->value('');
	  $this->byCssSelector('div#directory.tab-pane fieldset.uploadform div.form-actions input.btn')->click();
	  
	  // confirm successful install
	  $this->waitForCssSelector('div#j-main-container.span10 table.adminform tbody tr th', 20);
	  $this->assertContains('Installing component was successful.', $this->source());
	} 
}
?>