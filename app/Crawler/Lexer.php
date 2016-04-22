<?php

namespace App\Crawler;

/**
 * Class Lexer
 * @package App\Crawler
 */
final class Lexer
{
    const KEYWORDS = [
        'Assembler',
        'Assembly',
        'C#',
        'C++',
        'Closure',
        'Cobol',
        'Dart',
        'Delphi',
        'Erlang',
        'F#',
        'Fortran',
        'Groovy',
        'Haskel',
        'Java',
        'Lisp',
        'Objective-C',
        'PHP',
        'Pascal',
        'Perl',
        'Pike',
        'Prolog',
        'Python',
        'Ruby',
        'Rust',
        'Scala',
        'Scheme',
        'Swift',
        'Vala',
    ];

    /**
     * @param string $word
     *
     * @return bool
     */
    private function isKeyword(string $word) : bool
    {
        return in_array($word, self::KEYWORDS);
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