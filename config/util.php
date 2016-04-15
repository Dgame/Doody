<?php

/**
 * @param $value
 *
 * @return Closure
 */
function bind($value)
{
    return function () use ($value) {
        return $value;
    };
}

/**
 * @param bool   $cond
 * @param string $msg
 *
 * @throws Exception
 */
function enforce(bool $cond, string $msg)
{
    if (!$cond) {
        $args = func_get_args();
        array_shift($args);
        array_shift($args);
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