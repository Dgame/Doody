<?php

namespace App\Jobs;

use App\Crawler\Crawler;
use Illuminate\Contracts\Queue\ShouldQueue;

class Crawl extends Job implements ShouldQueue
{
    /**
     * @param Crawler $crawler
     */
    public function handle(Crawler $crawler)
    {
        $crawler->scan();
    }
}
