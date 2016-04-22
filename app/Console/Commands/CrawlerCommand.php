<?php

namespace App\Console\Commands;

use App\Jobs\CrawlerJob;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CrawlerCommand
 * @package App\Console\Commands
 */
final class CrawlerCommand extends Command
{
    const URLS = [
        'http://www.heise.de/developer/',
        'https://www.reddit.com/r/programming',
        'https://news.ycombinator.com/',
        'https://www.google.de/#q=programming+language'
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    use DispatchesJobs;

    /**
     *
     */
    public function fire()
    {
        foreach (self::URLS as $url) {
            $this->dispatch(new CrawlerJob($url));
        }
    }
}
