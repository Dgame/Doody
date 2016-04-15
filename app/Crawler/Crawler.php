<?php

namespace Modules\Crawler\Backend;

use Modules\Crawler\Backend\Client\Client;

/**
 * Class Crawler
 * @package Modules\Crawler\Backend
 */
final class Crawler
{
    /**
     * @var null|string
     */
    private $_url = null;

    /**
     * Crowler constructor.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->_url = $url;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->_url;
    }

    /**
     * @param Client $client
     * @param Lexer  $lexer
     */
    public function scan(Client $client, Lexer $lexer)
    {
        $content = $client->receive($this->getUrl());
        $score = $lexer->caclulateScore($content);

        print_r($score);
    }
}
