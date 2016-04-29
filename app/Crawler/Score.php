<?php

namespace App\Crawler;

/**
 * Class Score
 * @package App\Crawler
 */
final class Score
{
    const MIN_SCORE = 1;
    
    /**
     * @var array
     */
    private $_scores = [];

    /**
     * Score constructor.
     *
     * @param array $scores
     */
    public function __construct(array $scores)
    {
        $this->_scores = array_filter($scores, function(int $item) {
            return $item > 0;
        });
    }

    /**
     * @return array
     */
    public function getAllScores() : array
    {
        return $this->_scores;
    }

    /**
     * @param string $word
     *
     * @return int
     */
    public function getScoreOf(string $word) : int
    {
        if (array_key_exists($word, $this->_scores)) {
            return $this->_scores[$word];
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getTotalScore() : int
    {
        return array_sum($this->_scores);
    }
}