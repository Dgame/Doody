<?php

namespace Doody\Crowler;

/**
 * Class Score
 * @package Doody\Crowler
 */
final class Score
{
    /**
     * @var array
     */
    private $_results = [];

    /**
     * Score constructor.
     *
     * @param array $results
     */
    public function __construct(array $results)
    {
        $this->_results = array_filter($results, function ($item) {
            return $item > 0;
        });
    }

    /**
     * @return array
     */
    public function getResults() : array
    {
        return $this->_results;
    }

    /**
     * @param string $word
     *
     * @return int
     */
    public function getAmountOf(string $word) : int
    {
        if (array_key_exists($word, $this->_results)) {
            return $this->_results[$word];
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getTotalAmount() : int
    {
        return array_sum($this->_results);
    }
}