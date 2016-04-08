<?php

namespace Doody\Crowler;

/**
 * Class Crowler
 * @package Doody\Crowler
 */
final class Crowler
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

