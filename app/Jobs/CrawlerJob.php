<?php

namespace App\Jobs;

use App\Crawler\Crawler;
use App\Crawler\Lexer;
use App\Crawler\Provider\UrlProvider;
use App\Client\Client;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CrawlerJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    private $_url;

    public function __construct(string $url)
    {
        $this->_url = $url;
    }

    /**
     *
     */
    public function handle()
    {
        $client  = new Client();
        $lexer   = new Lexer(['java', 'perl', 'php']);
        $content = $client->receive($this->_url);
        $score   = $lexer->caclulateScore($content);

        $provider = new UrlProvider($content);
        $urls     = $provider->findUrls();
        var_dump($urls);
        exit;

        foreach ($urls as $url) {
            $this->dispatch(new CrawlerJob($url));
        }

        print_r($score);
    }
}
