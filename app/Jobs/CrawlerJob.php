<?php

namespace App\Jobs;

use App\Crawler\Lexer;
use App\Crawler\Provider\UrlProvider;
use App\Client\Client;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CrawlerJob extends Job implements SelfHandling, ShouldQueue
{
    /**
     * @var array
     */
    private static $Visited = [];

    /**
     * @var null|string
     */
    private $_url = null;

    use DispatchesJobs;

    /**
     * CrawlerJob constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->_url = $url;
    }

    /**
     * @return null|string
     */
    public function getUrl() : string
    {
        return $this->_url;
    }

    /**
     *
     */
    public function handle()
    {
        if ($this->alreadyVisited()) {
            return false;
        }

        $client = new Client();
        $lexer  = new Lexer();

        print sprintf('Visit %s', $this->getUrl()) . PHP_EOL;

        $content = $client->receive($this->getUrl());
        $score   = $lexer->caclulateScore($content);

        self::$Visited[$this->getUrl()] = true;

        preg_match_all('#<a href="(\w+.*?)"#i', $content, $urls);

        foreach (array_unique($urls[1]) as $url) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $this->dispatch(new CrawlerJob($url));
            }
        }

        //        print_r($score);

        return true;
    }

    /**
     * @return bool
     */
    private function alreadyVisited()
    {
        return array_key_exists($this->getUrl(), self::$Visited);
    }
}
