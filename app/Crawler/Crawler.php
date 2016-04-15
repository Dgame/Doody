<?php

namespace App\Crawler;

use App\Client\Client;
use App\Crawler\Provider\UrlProvider;
use App\Jobs\CrawlerJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Crawler
 * @package App\Crawler
 */
final class Crawler
{
    /**
     * @var int
     */
    private static $ID = 0;

    /**
     * @var int
     */
    private $_id = 0;
    /**
     * @var null|string
     */
    private $_url = null;
    /**
     * @var Client|null
     */
    private $_client = null;
    /**
     * @var Lexer|null
     */
    private $_lexer = null;

    use DispatchesJobs;

    /**
     * Crawler constructor.
     *
     * @param string $url
     * @param Client $client
     * @param Lexer  $lexer
     */
    public function __construct(string $url, Client $client, Lexer $lexer)
    {
        $this->_id     = self::$ID++;
        $this->_url    = $url;
        $this->_client = $client;
        $this->_lexer  = $lexer;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->_url;
    }

    /**
     * @return Client
     */
    public function getClient() : Client
    {
        return $this->_client;
    }

    /**
     * @return Lexer|null
     */
    public function getLexer()
    {
        return $this->_lexer;
    }

    /**
     * @param string $url
     *
     * @return Crawler
     */
    public function descendent(string $url)
    {
        return new self($url, $this->getClient(), $this->getLexer());
    }

    /**
     *
     */
    public function scan()
    {
        $content = $this->getClient()->receive($this->getUrl());
        $score   = $this->getLexer()->caclulateScore($content);

        $provider = new UrlProvider($content);
        $urls     = $provider->findUrls();

        foreach ($urls as $url) {
            $job = new CrawlerJob($this->descendent($url));
            $this->dispatch($job);
        }

        print_r($score);

        if ($this->getId() > 4) {
            exit;
        }
    }
}
