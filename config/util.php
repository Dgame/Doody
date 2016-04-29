<?php

/**
 * @param $value
 *
 * @return mixed
 */
function &ref(&$value)
{
    return $value;
}

/**
 * @example
 * <code>
 * function mapping($a) {
 *    var_dump($a); // int(42)
 * }
 *
 * $a = 42;
 * var_dump($a); // int(42)
 * mapping(move($a));
 * var_dump($a); // NULL
 * </code>
 *
 * @param $value
 *
 * @return mixed
 */
function move(&$value)
{
    $temp  = $value;
    $value = null;

    return $temp;
}

/**
 * @param $value
 *
 * @return Closure
 */
function bind($value)
{
    return function() use ($value) {
        return $value;
    };
}

/**
 * @param bool   $cond
 * @param string $msg
 * @param array  ...$args
 *
 * @throws Exception
 */
function enforce(bool $cond, string $msg, ...$args)
{
    if (!$cond) {
        if (!empty($args)) {
            $msg = vsprintf($msg, $args);
        }

        throw new Exception($msg);
    }
}

/**
 * @param $value
 */
function debug($value)
{
    //    print '<pre>';
    if (is_array($value) || is_object($value)) {
        print_r($value);
    } else {
        var_dump($value);
    }
    //    print '</pre>';
}

/**
 * @param $value
 */
function debug_abort($value)
{
    debug($value);
    exit;
}