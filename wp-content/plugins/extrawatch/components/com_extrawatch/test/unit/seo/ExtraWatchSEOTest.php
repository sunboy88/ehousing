<?php

require_once 'PHPUnit/Autoload.php';
require_once(realpath(dirname(__FILE__).DIRECTORY_SEPARATOR."..").DIRECTORY_SEPARATOR."ExtraWatchTestBase.php");

class ExtraWatchSEOTest extends ExtraWatchTestBase
{

    const GOOGLE_SEARCH_RESULT_NUM_1 = 15;
    const GOOGLE_SEARCH_RESULT_NUM_2 = 5;

    const TEST_QUERY_1 = "test query";
    const TEST_QUERY_2 = "test query 2";

    const USER_AGENT_HTC_DESIRE_Z = "Mozilla/5.0 (Linux; U; Android 2.3.3; en-gb; HTC_DesireZ_A7272 Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1";
    const REFERER_GOOGLE_SK = "https://www.google.sk/url?sa=t&rct=j&q=TEST_QUERY&esrc=s&source=web&cd=GOOGLE_SEARCH_RESULT_NUM&cad=rja&ved=0CCsQFjAA&url=http%3A%2F%2Fstackoverflow.com%2Fquestions%2F834303%2Fphp-startswith-and-endswith-functions&ei=s3fNUZfgHtGQswad8YCIDw&usg=AFQjCNGclgW9oIQ9p3H4x6WjW8G1BH-BdA&bvm=bv.48572450,d.Yms";

    const PAGE_URI = "/";

    public function testSEO_keyphrases()
    {
        $this->simulateVisitFromGoogle();
        $keyPhrase = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYPHRASE, $this->day);
        $this->assertEquals($keyPhrase[0]->name, "test query");
    }

    public function testSEO_keywords()
    {
        $this->simulateVisitFromGoogle();
        $keywords = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_KEYWORDS, $this->day);
        $this->assertEquals(sizeof($keywords), 2);
        $this->assertEquals($keywords[0]->name, "test");
        $this->assertEquals($keywords[0]->value, 1);
        $this->assertEquals($keywords[1]->name, "query");
        $this->assertEquals($keywords[1]->value, 1);
    }


    public function testSEO_retrieveTopUrisReferedByKeyphraseForDay()
    {
        $this->simulateVisitFromGoogle();

        $uri = "/";
        $title = "No title";

        $searchResPosition = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_SEARCH_RESULT_NUM, $this->day);
        $keyphrase = $this->extraWatch->visit->getKeyphraseByUriId($searchResPosition[0]->name, $uri);

        $keyphraseId = $this->extraWatch->visit->getKeyphraseId(self::TEST_QUERY_1);
        $uriId = $this->extraWatch->visit->getUriIdByUriName($uri);

        $this->assertEquals($keyphrase, self::TEST_QUERY_1);

        $topUrisByKeyphrase = $this->extraWatch->seo->retrieveTopUrisReferedByKeyphraseForDay($this->day);
        $this->assertNotEmpty($topUrisByKeyphrase);
        $this->assertEquals($topUrisByKeyphrase[0]->uriId, $uriId);
        $this->assertEquals($topUrisByKeyphrase[0]->title, $title);
        $this->assertEquals($topUrisByKeyphrase[0]->total, 1);

        $this->extraWatch->visit->updateVisitByBrowser($uri, self::REFERER_GOOGLE_SK);

        $topUrisByKeyphrase = $this->extraWatch->seo->retrieveTopUrisReferedByKeyphraseForDay($this->day);
        $this->assertNotEmpty($topUrisByKeyphrase);
        $this->assertEquals($topUrisByKeyphrase[0]->uriId, $keyphraseId);
        $this->assertEquals($topUrisByKeyphrase[0]->title, $title);
        $this->assertEquals($topUrisByKeyphrase[0]->total, 2); // value for same query increased

    }

    public function testSEO_retrieveKeyphrasesForDayAndUriId()
    {
        $this->simulateVisitFromGoogle();

        $searchResPosition = $this->extraWatch->stat->getIntValuesByName(EW_DB_KEY_SEARCH_RESULT_NUM, $this->day);
        $keyphrase = $this->extraWatch->visit->getKeyphraseByUriId($searchResPosition[0]->name, "/");

        $keyphraseId = $this->extraWatch->visit->getKeyphraseId(self::TEST_QUERY_1);
        $uriId = $this->extraWatch->visit->getUriIdByUriName($this->extraWatch->helper->getUri());

        $this->assertEquals($keyphrase, self::TEST_QUERY_1);

        $topUrisByDateAndKeyphrase = $this->extraWatch->seo->retrieveKeyphrasesForDayAndUriId($this->day, $uriId);
        $this->assertNotEmpty($topUrisByDateAndKeyphrase);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->uri2keyphraseId, $keyphraseId);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->name, self::TEST_QUERY_1);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->value, 1); // value for same query increased

        $this->extraWatch->visit->updateVisitByBrowser("/", self::REFERER_GOOGLE_SK);

        $topUrisByDateAndKeyphrase = $this->extraWatch->seo->retrieveKeyphrasesForDayAndUriId($this->day, $uriId);
        $this->assertNotEmpty($topUrisByDateAndKeyphrase);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->uri2keyphraseId, $uriId);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->name, self::TEST_QUERY_1);
        $this->assertEquals($topUrisByDateAndKeyphrase[0]->value, 2); // value for same query increased
    }


    public function testSEO_getTotalVisitsByKeyphrasesByDay()
    {
        $this->simulateVisitFromGoogle();
        $this->assertEquals($this->extraWatch->seo->getTotalVisitsByKeyphrasesByDay( ($this->day-1) ), 0);
        $this->assertEquals($this->extraWatch->seo->getTotalVisitsByKeyphrasesByDay($this->day), 1);
        $this->simulateVisitFromGoogle();
        $this->assertEquals($this->extraWatch->seo->getTotalVisitsByKeyphrasesByDay($this->day), 2);
    }

    public function testSEO_getMostChangedKeyphrases()
    {
        $this->assertEmpty($this->extraWatch->seo->getMostChangedKeyphrases());

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1);
        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_2);

        $mostChangedKeyphrases = $this->extraWatch->seo->getMostChangedKeyphrases();
        $this->assertNotEmpty($this->extraWatch->seo->getMostChangedKeyphrases());

        $this->assertEquals($mostChangedKeyphrases[0]->name, self::TEST_QUERY_1);
        $this->assertEquals($mostChangedKeyphrases[0]->maxPosition, self::GOOGLE_SEARCH_RESULT_NUM_1);
        $this->assertEquals($mostChangedKeyphrases[0]->minPosition, self::GOOGLE_SEARCH_RESULT_NUM_2);
        $this->assertEquals($mostChangedKeyphrases[0]->averagePosition, (self::GOOGLE_SEARCH_RESULT_NUM_1 + self::GOOGLE_SEARCH_RESULT_NUM_2) / 2);
        $this->assertEquals($mostChangedKeyphrases[0]->difference, abs((self::GOOGLE_SEARCH_RESULT_NUM_2 - self::GOOGLE_SEARCH_RESULT_NUM_1)));
        $this->assertEquals($mostChangedKeyphrases[0]->count, 2);
    }

    public function testSEO_getPositionByUri2KeyphraseId() {

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_1);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1);

        $this->assertEquals($this->extraWatch->seo->getAveragePositionChangesByUri2KeyphraseId($uri2keyphraseId), self::GOOGLE_SEARCH_RESULT_NUM_1);
    }


    public function testSEO_getAveragePositionChangesByUri2KeyphraseId()
    {
        $this->assertNull($this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1));

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_1);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1);
        $this->assertEquals($uri2keyphraseId, 1);

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_1);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1);
        $this->assertEquals($uri2keyphraseId, 1);

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_2);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_2);
        $this->assertEquals($uri2keyphraseId, 2);

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_2, self::TEST_QUERY_2);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_2);
        $this->assertEquals($uri2keyphraseId, 2);

        $averagePosition = $this->extraWatch->seo->getAveragePositionChangesByUri2KeyphraseId($uri2keyphraseId);
        $this->assertNotEmpty($averagePosition);
        $this->assertEquals(sizeof($averagePosition),1);
        $this->assertEquals($averagePosition[0]->averagePosition, (self::GOOGLE_SEARCH_RESULT_NUM_1 + self::GOOGLE_SEARCH_RESULT_NUM_2) /2);

    }


    public function testSEO_getAveragePositionChangesByUri2KeyphraseIdBetweenDays()
    {
        $this->day = $this->day - 1;    //TODO must be able to insert with yesterday's date
        $this->testSEO_getAveragePositionChangesByUri2KeyphraseId();

        $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_1);
        $uri2keyphraseId = $this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1);
        $this->assertEquals($uri2keyphraseId, 1);
        $averagePosition = $this->extraWatch->seo->getAveragePositionChangesByUri2KeyphraseIdBetweenDays($uri2keyphraseId, 2);

    }


    public function testSEO_cleanUnimportantKeyphrases() {

    $this->assertNull($this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1));
    $this->simulateVisitFromGoogle(self::GOOGLE_SEARCH_RESULT_NUM_1, self::TEST_QUERY_1);
    $this->assertNotNull($this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1));
    $this->extraWatch->seo->cleanUnimportantKeyphrases();  //TODO must be able to insert visits with previous date
    $this->assertNotNull($this->extraWatch->visit->getUri2KeyphraseByUriKeyphrase($this->extraWatch->helper->getUri(), self::TEST_QUERY_1));
}


    private function simulateVisitFromGoogle($searchResultPosition = self::GOOGLE_SEARCH_RESULT_NUM_1, $keyphrase = self::TEST_QUERY_1)
    {
        $_SERVER['HTTP_USER_AGENT'] = self::USER_AGENT_HTC_DESIRE_Z;
        $referer = $this->changeRefererWithPositionAndKeyphrase($searchResultPosition, $keyphrase);

        $this->extraWatch->visit->updateVisitByBrowser("/", $referer);
    }



    private function changeRefererWithPositionAndKeyphrase($position, $keyphrase)
    {
        $refererWithSearchResultNum = str_replace("GOOGLE_SEARCH_RESULT_NUM", $position, self::REFERER_GOOGLE_SK);
        $refererWithTestQuery = str_replace("TEST_QUERY", urlencode($keyphrase), $refererWithSearchResultNum);
        $_SERVER['HTTP_REFERER'] = $refererWithTestQuery;
        return $refererWithTestQuery;
    }

}