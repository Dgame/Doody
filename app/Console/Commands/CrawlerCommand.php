<?php

namespace App\Console\Commands;

use App\Client\Client;
use App\Crawler\Crawler;
use App\Jobs\CrawlerJob;
use App\Crawler\Lexer;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class CrawlerCommand
 * @package App\Console\Commands
 */
final class CrawlerCommand extends Command
{
    use DispatchesJobs;

    /**
     *
     */
    const KEYWORDS = [
        'Assembler',
        'Assembly',
        'C#',
        'C++',
        'Closure',
        'Cobol',
        'Dart',
        'Delphi',
        'Erlang',
        'F#',
        'Fortran',
        'Groovy',
        'Haskel',
        'Java',
        'Lisp',
        'Objective-C',
        'PHP',
        'Pascal',
        'Perl',
        'Pike',
        'Prolog',
        'Python',
        'Ruby',
        'Rust',
        'Scala',
        'Scheme',
        'Swift',
        'Vala',
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

    /**
     * @var Client|null
     */
    private $_client = null;
    /**
     * @var Lexer|null
     */
    private $_lexer = null;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_client = new Client();
        $this->_lexer  = new Lexer(self::KEYWORDS);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->_client;
    }

    /**
     * @return Lexer
     */
    public function getLexer(): Lexer
    {
        return $this->_lexer;
    }

    /**
     *
     */
    public function fire()
    {
        //$crawler = new Crawler('http://www.heise.de/developer/', $this->getClient(), $this->getLexer());
        $this->dispatch(new CrawlerJob('http://heise.de'));
    }
}
