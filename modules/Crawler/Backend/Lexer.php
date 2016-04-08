<?php

namespace Modules\Crawler\Backend;

/**
 * Class Lexer
 * @package Modules\Crawler\Backend
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
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $json = file_get_contents($filename);

        $this->_keywords = json_decode($json, true)['Keywords'];
        $this->_keywords = array_map('strtolower', $this->_keywords);
    }

    /**
     * @param string $content
     *
     * @return Score
     */
    public function caclulateScore(string $content) : Score
    {
        $results = [];
        $content = strtolower(strip_tags($content));
        foreach ($this->_keywords as $kword) {
            $results[$kword] = 0;

            $len = strlen($kword) - 1;
            $pos = 0;
            while (($pos = strpos($content, $kword, $pos)) !== false) {
                $results[$kword]++;
//                print 'Found keword ' . $kword . ' @ ' . $pos . PHP_EOL;
                $pos += $len;
            }
        }

        return new Score($results);
    }
}