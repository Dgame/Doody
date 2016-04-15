<?php

namespace App\Jobs;

use App\Crawler\Crawler;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class CrawlerJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Crawler|null
     */
    private $_crawler = null;

    /**
     * CrawlerJob constructor.
     *
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->_crawler = $crawler;
    }

    /**
     * @return Crawler
     */
    public function getCrawler() : Crawler
    {
        return $this->_crawler;
    }

    /**
     *
     */
    public function handle()
    {
        $this->getCrawler()->scan();
    }
}
