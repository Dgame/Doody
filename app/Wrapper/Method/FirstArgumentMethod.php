<?php

namespace App\Wrapper\Method;

/**
 * Class FirstArgumentMethod
 * @package App\Wrapper\Method
 */
final class FirstArgumentMethod extends Method
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
        array_unshift($args, $value);

        return $args;
    }
}
