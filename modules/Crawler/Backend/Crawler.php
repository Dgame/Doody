<?php

namespace Modules\Crawler\Backend;

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

    public function getUrl() : string
    {
        return $this->_url;
    }

    /**
     *
     */
    public function scan()
    {
        
    }
}

