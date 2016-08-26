<?php

require("../../ExtraWatchGUITestBase.php");

class ExtraWatchLinksTest extends ExtraWatchGUITestBase {
	

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
  public function testHomeEwLiks() {
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
	
	//check support links
	$linkFQA = $this->byPartialLinkText('FAQ');
	$this->assertEquals('http://www.extrawatch.com/faq/', $linkFQA->attribute('href'));
	
	$linkRF = $this->byPartialLinkText('Request Feature');
	$this->assertEquals('http://www.extrawatch.com/support/', $linkRF->attribute('href'));
	
	$linkDemo = $this->byPartialLinkText('Demo');
	$this->assertEquals('http://www.extrawatch.com/demos/', $linkDemo->attribute('href'));
	
	$linkReview = $this->byPartialLinkText('Write a Review');
	$this->assertEquals('http://extensions.joomla.org/extensions/site-management/visitors/24824/review', $linkReview->attribute('href'));
	
	$linkVote = $this->byPartialLinkText('Please cast your vote');
	$this->assertEquals('http://extensions.joomla.org/extensions/site-management/visitors/24824', $linkVote->attribute('href'));
  } 
  public function testLinkPages() {
	
	$this->url(self::JOOMLA_PATH.'/administrator/index.php?option=com_extrawatch');
	
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
	
	//visitors
	$this->assertTag(array('content' => 'Visitors'), $this->source()); 
	$link = $this->byPartialLinkText('Visitors')->click();
	$this->waitForCssSelector('td#visits h3', 20);
	$headingH3 = $this->byCssSelector('td#visits h3')->text();
	$this->assertContains('Latest Visitors', $headingH3);
	//clicks
	$this->assertTag(array('content' => 'Clicks'), $this->source());
	$link1 = $this->byPartialLinkText('Clicks')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingHeatmap = $this->byCssSelector('h2')->text();
	$this->assertContains('Heatmap', $headingHeatmap);
	//users
	$this->url(self::JOOMLA_PATH.'/administrator/index.php?option=com_extrawatch&task=users&action=');
	$this->waitForCssSelector('section#content h2', 20);
	$headinguser = $this->byCssSelector('h2')->text();
	$this->assertContains('Users', $headinguser);
	//SEO
	$this->assertTag(array('content' => 'SEO'), $this->source());
	$link1 = $this->byPartialLinkText('SEO')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingSEO = $this->byCssSelector('h2')->text();
	$this->assertContains('SEO Report', $headingSEO);
	//Downloads
	$this->assertTag(array('content' => 'Downloads'), $this->source());
	$link1 = $this->byPartialLinkText('Downloads')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingDownloads = $this->byCssSelector('h2')->text();
	$this->assertContains('Download Monitor', $headingDownloads);
	//Flow
	$this->assertTag(array('content' => 'Flow'), $this->source());
	$link1 = $this->byPartialLinkText('Flow')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingFlow = $this->byCssSelector('h2')->text();
	$this->assertContains('Traffic Flow', $headingFlow);
	//Graphs
	$this->assertTag(array('content' => 'Graphs'), $this->source());
	$link1 = $this->byPartialLinkText('Graphs')->click();
	$this->waitForCssSelector('section#content select', 20);
	$selectGraphs = $this->byCssSelector('section#content select')->attribute('name');
	$this->assertEquals('group', $selectGraphs); 
	//Goals
	$this->assertTag(array('content' => 'Goals'), $this->source());
	$link1 = $this->byPartialLinkText('Goals')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingGoals = $this->byCssSelector('h2')->text();
	$this->assertContains('New goal', $headingGoals);
	//History
	$this->assertTag(array('content' => 'History'), $this->source());
	$link1 = $this->byPartialLinkText('History')->click();
	$this->waitForCssSelector('section#content h3', 20);
	$headingHistory = $this->byCssSelector('h3')->text();
	$this->assertContains('Visitors History', $headingHistory);
	//Anti-Spam
	$this->assertTag(array('content' => 'Anti-Spam'), $this->source());
	$link1 = $this->byPartialLinkText('Anti-Spam')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingSpam = $this->byCssSelector('h2')->text();
	$this->assertContains('Anti-Spam', $headingSpam);
	//Emails
	$this->assertTag(array('content' => 'Emails'), $this->source());
	$link1 = $this->byPartialLinkText('Emails')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingEmails = $this->byCssSelector('h2')->text();
	$this->assertContains('Email Reports', $headingEmails);
	//DB Status
	$this->assertTag(array('content' => 'DB Status'), $this->source());
	$link1 = $this->byPartialLinkText('DB Status')->click();
	$this->waitForCssSelector('section#content h2', 30);
	$headingDB = $this->byCssSelector('h2')->text();
	$this->assertContains('Database Table Sizes', $headingDB);
	//Settings
	$this->assertTag(array('content' => 'Settings'), $this->source());
	$link1 = $this->byPartialLinkText('Settings')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingSettings = $this->byCssSelector('h2')->text();
	$this->assertContains('Settings', $headingSettings);
	//Credits
	$this->assertTag(array('content' => 'Credits'), $this->source());
	$link1 = $this->byPartialLinkText('Credits')->click();
	$this->waitForCssSelector('section#content h2', 20);
	$headingCredits = $this->byCssSelector('h2')->text();
	$this->assertContains('Credits', $headingCredits);
	//Sizes
	$this->assertTag(array('content' => 'Sizes'), $this->source());
	$link1 = $this->byPartialLinkText('Sizes')->click();
	$this->waitForCssSelector('h2', 20);
	$headingSizes = $this->byCssSelector('h2')->text();
	$this->assertContains('Files & Directories', $headingSizes);
  }
}

