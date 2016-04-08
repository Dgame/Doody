<?php

namespace Doody\Crowler;

final class Crowler
{
    private $_urls    = [];
    private $_context = null;
    private $_lexer   = null;

    public function __construct()
    {
        $context = [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];

        $this->_context = stream_context_create($context);
        $this->_lexer = new Lexer();

        libxml_use_internal_errors(true);
    }

    public function getURLs() : array
    {
        return array_keys($this->_urls);
    }

    public function isAlreadyVisited(string $url) : bool
    {
        return array_key_exists($url, $this->_urls);
    }

    public function visitMultiple(array $urls)
    {
        foreach ($urls as $url) {
            $this->visit($url);
        }
    }

    public function visit(string $url) : bool
    {
        $content = file_get_contents($url, false, $this->_context);
        if (!empty($content)) {
            $score = $this->_lexer->caclulateScore($content);
            if ($score->getTotalAmount() === 0) {
                return false;
            }

            $doc = new \DOMDocument('1.0', 'utf-8');
            $doc->loadHTML($content);

            $links = $doc->getElementsByTagName('a');
            for ($i = 0; $i < $links->length; $i++) {
                $url = $links->item($i)->getAttribute('href');
                //                $url = parse_url($url, PHP_URL_HOST);
                if (!empty($url) &&
                    Store::Instance()->isValid($url) &&
                    !Store::Instance()->isAlreadyVisited($url) &&
                    !$this->isAlreadyVisited($url)
                ) {
                    $this->_urls[$url] = true;
                }
            }

            Store::Instance()->insertFrom($this, $score, $url);

            return true;
        }

        return false;
    }

    public function revisit()
    {
        $chunks = array_chunk($this->getURLs(), 24);
        foreach ($chunks as $urls) {
            $c = new Crowler();
            $c->visitMultiple($urls);
            $c->revisit();
        }
    }
}

