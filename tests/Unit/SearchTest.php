<?php

use DivineOmega\BaseSearch\Interfaces\SearchResultInterface;
use DivineOmega\RedditSearch\RedditSearcher;
use DivineOmega\RedditSearch\RedditSearchResult;
use PHPUnit\Framework\TestCase;

final class SearchTest extends TestCase
{
    public function testSearch()
    {
        $searcher = new RedditSearcher();

        $results = $searcher->search('PHP programming language');

        $this->assertGreaterThanOrEqual(1, count($results));

        foreach($results as $result) {
            $this->assertTrue($result instanceof RedditSearchResult);
            $this->assertTrue($result instanceof SearchResultInterface);

            $this->assertGreaterThanOrEqual(0, $result->getScore());
            $this->assertLessThanOrEqual(1, $result->getScore());
        }
    }

}
