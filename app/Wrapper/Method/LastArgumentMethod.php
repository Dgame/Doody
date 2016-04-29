<?php

namespace App\Wrapper\Method;

/**
 * Class LastArgumentMethod
 * @package App\Wrapper\Method
 */
final class LastArgumentMethod extends Method
{
    /**
     * @param       $arg
     * @param array $args
     *
     * @return array
     */
    public function apply(&$arg, array $args)
    {
        $value = $arg;
        array_push($args, $value);

        return $args;
    }
}