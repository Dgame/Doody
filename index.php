<?php

use Doody\Crowler\Crowler;

function __autoload($className)
{
    $parts = explode('\\', $className);
    if ($parts[0] === 'Doody') {
        unset($parts[0]);
    }

    $parts    = array_map('lcfirst', $parts);
    $filename = implode('/', $parts) . '.php';

    if (file_exists($filename)) {
        require_once $filename;

        return true;
    }

    return false;
}

$urls = [
    'https://en.wikipedia.org/wiki/List_of_programming_languages',
    'http://www.golem.de/',
    'http://www.heise.de/developer/',
    'http://techcrunch.com/',
    'https://news.ycombinator.com/',
    'http://drdobbs.com'
];
