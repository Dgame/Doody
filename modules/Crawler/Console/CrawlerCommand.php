<?php

namespace Modules\Crawler\Console;

use Illuminate\Console\Command;
use Modules\Crawler\Backend\Client\Client;
use Modules\Crawler\Backend\Crawler;
use Modules\Crawler\Backend\Lexer;

/**
 * Class CrawlerCommand
 * @package Modules\Crawler\Console
 */
final class CrawlerCommand extends Command
{
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
        'Vala'
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'command:crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
    public function getClient() : Client
    {
        return $this->_client;
    }

    /**
     * @return Lexer
     */
    public function getLexer() : Lexer
    {
        return $this->_lexer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $crawler = new Crawler('http://www.heise.de/developer/');
        $crawler->scan($this->getClient(), $this->getLexer());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
