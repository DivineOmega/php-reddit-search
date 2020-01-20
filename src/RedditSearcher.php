<?php

namespace DivineOmega\RedditSearch;

use DivineOmega\BaseSearch\Interfaces\SearcherInterface;

class RedditSearcher implements SearcherInterface
{
    const URL = 'https://www.reddit.com/search/.json?q=[QUERY]';

    public function search(string $query): array
    {
        $url = $this->buildUrl($query);

        $response = file_get_contents($url);
        $decodedResponse = json_decode($response, true);

        $results = [];

        $count = count($decodedResponse['data']['children']);

        foreach ($decodedResponse['data']['children'] as $index => $item) {
            $score = ($count - $index) / $count;
            $results[] = new RedditSearchResult($item, $score);
        }

        return $results;
    }

    private function buildUrl(string $query): string
    {
        return str_replace(
            ['[QUERY]'],
            [urlencode($query)],
            self::URL
        );
    }
}