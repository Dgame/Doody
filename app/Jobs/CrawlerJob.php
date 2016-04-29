<?php

namespace App\Jobs;

use App\Crawler\Score;
use App\Page;
use App\Crawler\Lexer;
use App\Client\Client;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CrawlerJob extends Job implements SelfHandling, ShouldQueue
{
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
    public function getUrl(): string
    {
        return $this->_url;
    }

    /**
     *
     */
    public function handle(): bool
    {
        if ($this->alreadyVisited()) {
            return false;
        }

        $client = new Client();

        print sprintf('Visit %s', $this->getUrl()) . PHP_EOL;

        $content = $client->receive($this->getUrl());
        $score   = Lexer::Instance()->caclulateScore($content);

        print_r($score);
        if ($score->getTotalScore() < Score::MIN_SCORE) {
            return false;
        }

        //        $page->url   = $this->getUrl();
        //        $page->score = $score;
        //        $result      = $page->save();

        preg_match_all('#<a href="(\w+.*?)"#i', $content, $urls);

        foreach (array_unique($urls[1]) as $url) {
            if (filter_var($url, FILTER_VALIDATE_URL)) {
                $this->dispatch(new CrawlerJob($url));
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    private function alreadyVisited(): bool
    {
        return false;//return Page::where('url', '=', $this->getUrl())->first() ? true : false;
    }
}
