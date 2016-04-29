<?php

namespace App\Crawler;

use App\Wrapper\ArrayWrapper;
use App\Wrapper\Wrapper;

/**
 * Class Lexer
 * @package App\Crawler
 */
final class Lexer
{
    /**
     * @var null|Lexer
     */
    private static $instance = null;
    /**
     * @var ArrayWrapper|null
     */
    private $_whitelist = [];

    /**
     * Lexer constructor.
     */
    private function __construct()
    {
        $this->_whitelist = Wrapper::dict(
            'github',
            'svn',
            'php',
            'c++',
            'java',
            'rust',
            'rustlang',
            'golang',
            'sql',
            'mysql',
            'nosql',
            'scala',
            'haskell',
            'hardware',
            'software',
            'android',
            'ios',
            'smalltalk',
            'framework',
            'programmiersprache',
            'algorithmen',
            'programming',
            'developer',
            'entwickler',
            'programmierer'
        );
    }

    /**
     * @return ArrayWrapper|null
     */
    public function getWhitelist()
    {
        return $this->_whitelist;
    }

    /**
     * @return Lexer|null
     */
    public static function Instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $word
     *
     * @return bool
     */
    private function isOnWhitelist(string $word) : bool
    {
        return $this->getWhitelist()->keyExists($word);
    }

    /**
     * @param string $content
     *
     * @return array
     */
    private function disassemble(string $content) : array
    {
        $content = strip_tags($content);
        $content = preg_replace('#[^\w]#i', ' ', $content);
        $words   = preg_split('#[\s\t\v]#', $content);

        return Wrapper::of($words)->map('trim')->filter()->asArray();
    }

    /**
     * @param string $content
     *
     * @return Score
     */
    public function caclulateScore(string $content) : Score
    {
        $results = new ArrayWrapper();
        foreach ($this->disassemble($content) as $word) {
            $word = Wrapper::string($word)->toLower();
            if ($this->isOnWhitelist($word)) {
                $value = 0;
                if ($results->keyExists($word)) {
                    $value = $results[$word] + 1;
                }

                $results[$word] = $value;
            }
        }

        return new Score($results->asArray());
    }
}