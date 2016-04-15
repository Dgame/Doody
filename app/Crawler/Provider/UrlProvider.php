<?php

namespace App\Crawler\Provider;

/**
 * Class UrlProvider
 * @package App\Crawler\Provider
 */
final class UrlProvider
{
    /**
     * @var \DOMDocument|null
     */
    private $_doc = null;

    /**
     * UrlProvider constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        if (@$doc->loadHTML($content) === false) {
            print 'Webseite konnte nicht geladen werden' . PHP_EOL;
        }

        $this->_doc = $doc;
    }

    /**
     * @return \DOMDocument
     */
    public function getDoc() : \DOMDocument
    {
        return $this->_doc;
    }

    /**
     * @return array
     */
    public function findUrls() : array
    {
        $as = $this->getDoc()->getElementsByTagName('a');

        $urls = [];
        for ($i = 0; $i < $as->length; $i++) {
            if ($as->item($i)->hasAttributes() && !empty($as->item($i)->getAttribute('href'))) {
                $urls[] = $as->item(0)->getAttribute('href');
            }
        }

        return $urls;
    }
}