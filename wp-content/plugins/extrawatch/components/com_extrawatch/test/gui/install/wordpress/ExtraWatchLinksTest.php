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
 
  public function testHomeEwLiks() {
	$this->url(self::WP_PATH.'/wp-admin/admin.php?page=extrawatch&task=settings&action=');
	//second login
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
	
	//check support links
	$linkFQA = $this->byPartialLinkText('FAQ');
	$this->assertEquals('http://www.extrawatch.com/faq/', $linkFQA->attribute('href'));
	
	$linkRF = $this->byPartialLinkText('Request Feature');
	$this->assertEquals('http://www.extrawatch.com/support/', $linkRF->attribute('href'));
	
	$linkDemo = $this->byPartialLinkText('Demo');
	$this->assertEquals('http://www.extrawatch.com/demos/', $linkDemo->attribute('href'));
	
	$linkReview = $this->byPartialLinkText('Write a Review');
	$this->assertEquals('http://www.wordpress.org/support/view/plugin-reviews/extrawatch-pro', $linkReview->attribute('href'));
	
	$linkVote = $this->byPartialLinkText('Please cast your vote');
	$this->assertEquals('http://www.wordpress.org/support/view/plugin-reviews/extrawatch-pro', $linkVote->attribute('href'));
  } 
  public function testLinkPages() {
	
	$this->url(self::WP_PATH.'/wp-admin/admin.php?page=extrawatch');
	
	//second login
	$form = $this->byCssSelector('#loginform');
	$username = $this->byId('user_login');
	$password = $this->byId('user_pass');
	
	$username->clear();
	$password->clear();
	
	$username->value('demo');
	$password->value('demo');
	$form->submit();
	//admin page 
	$this->assertContains('ExtraWatch', $this->title());
	
	//visitors
	$this->assertTag(array('content' => 'Visitors'), $this->source()); 
	$link = $this->byPartialLinkText('Visitors')->click();
	$this->waitForCssSelector('td#visits h3', 10);
	$headingH3 = $this->byCssSelector('td#visits h3')->text();
	$this->assertContains('Latest Visitors', $headingH3);
	//heatmap
	$this->assertTag(array('content' => 'Heatmap'), $this->source());
	$link1 = $this->byPartialLinkText('Heatmap')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingHeatmap = $this->byCssSelector('h2')->text();
	$this->assertContains('Click Heatmap', $headingHeatmap);
	//Clicks Areas
	$this->assertTag(array('content' => 'Click Areas'), $this->source());
	$link1 = $this->byPartialLinkText('Click Areas')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headinguser = $this->byCssSelector('h2')->text();
	$this->assertContains('Clicks Areas', $headinguser);
	//SEO
	$this->assertTag(array('content' => 'SEO'), $this->source());
	$link1 = $this->byPartialLinkText('SEO')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingSEO = $this->byCssSelector('h2')->text();
	$this->assertContains('SEO Report', $headingSEO);
	//users
	$this->assertTag(array('content' => 'Users'), $this->source());
	$link1 = $this->byPartialLinkText('Users')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headinguser = $this->byCssSelector('h2')->text();
	$this->assertContains('Users', $headinguser);
	//Downloads
	$this->assertTag(array('content' => 'Downloads'), $this->source());
	$link1 = $this->byPartialLinkText('Downloads')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingDownloads = $this->byCssSelector('h2')->text();
	$this->assertContains('Download Monitor', $headingDownloads);
	//Flow
	$this->assertTag(array('content' => 'Flow'), $this->source());
	$link1 = $this->byPartialLinkText('Flow')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingFlow = $this->byCssSelector('h2')->text();
	$this->assertContains('Traffic Flow', $headingFlow);
	//Goals
	$this->assertTag(array('content' => 'Goals'), $this->source());
	$link1 = $this->byPartialLinkText('Goals')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingGoals = $this->byCssSelector('h2')->text();
	$this->assertContains('New goal', $headingGoals);
	//Graphs
	$this->assertTag(array('content' => 'Graphs'), $this->source());
	$link1 = $this->byPartialLinkText('Graphs')->click();
	$this->waitForCssSelector('section#content select', 10);
	$selectGraphs = $this->byCssSelector('div#wpbody-content div.wrap table tbody tr td div form select')->attribute('name');
	$this->assertEquals('group', $selectGraphs); 
	//History
	$this->assertTag(array('content' => 'History'), $this->source());
	$link1 = $this->byPartialLinkText('History')->click();
	$this->waitForCssSelector('section#content h3', 10);
	$headingHistory = $this->byCssSelector('h3')->text();
	$this->assertContains('Visitors History', $headingHistory);
	//Anti-Spam
	$this->assertTag(array('content' => 'Anti-Spam'), $this->source());
	$link1 = $this->byPartialLinkText('Anti-Spam')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingSpam = $this->byCssSelector('h2')->text();
	$this->assertContains('Anti-Spam', $headingSpam);
	//Emails
	$this->assertTag(array('content' => 'Emails'), $this->source());
	$link1 = $this->byPartialLinkText('Emails')->click();
	$this->waitForCssSelector('section#content h2', 10);
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
	$this->waitForCssSelector('section#content h2', 10);
	$headingSettings = $this->byCssSelector('h2')->text();
	$this->assertContains('Settings', $headingSettings);
	//Credits
	$this->assertTag(array('content' => 'Credits'), $this->source());
	$link1 = $this->byPartialLinkText('Credits')->click();
	$this->waitForCssSelector('section#content h2', 10);
	$headingCredits = $this->byCssSelector('h2')->text();
	$this->assertContains('Credits', $headingCredits);
	//Sizes
	$this->assertTag(array('content' => 'Sizes'), $this->source());
	$link1 = $this->byPartialLinkText('Sizes')->click();
	$this->waitForCssSelector('h2', 10);
	$headingSizes = $this->byCssSelector('h2')->text();
	$this->assertContains('Files & Directories', $headingSizes);
  }
}

