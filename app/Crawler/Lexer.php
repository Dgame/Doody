<?php

namespace App\Crawler;

/**
 * Class Lexer
 * @package App\Crawler
 */
final class Lexer
{
    /**
     * @var array
     */
    private $_keywords = [];

    /**
     * Lexer constructor.
     *
     * @param array $keywords
     */
    public function __construct(array $keywords)
    {
        $this->_keywords = array_map('strtolower', $keywords);
    }

    /**
     * @return array
     */
    public function getKeywords() : array
    {
        return $this->_keywords;
    }

    /**
     * @param string $word
     *
     * @return bool
     */
    private function isKeyword(string $word) : bool
    {
        return in_array($word, $this->getKeywords());
    }

    /**
     * @param string $content
     *
     * @return array
     */
    private function disassemble(string $content) : array
    {
        $content = strip_tags($content);
        $words   = explode(' ', $content);

        return array_map('strtolower', $words);
    }

    /**
     * @param string $content
     *
     * @return Score
     */
    public function caclulateScore(string $content) : Score
    {
        $results = [];
        foreach ($this->disassemble($content) as $word) {
            if ($this->isKeyword($word)) {
                $value = 0;
                if (array_key_exists($word, $results)) {
                    $value = $results[$word] + 1;
                }

                $results[$word] = $value;
            }
        }

        return new Score($results);
    }
}