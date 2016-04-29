<?php

namespace App\Wrapper\Method;

/**
 * Class RefArgumentMethod
 * @package App\Wrapper\Method
 */
final class RefArgumentMethod extends Method
{
    /**
     * @param       $arg
     * @param array $args
     *
     * @return array
     */
    public function apply(&$arg, array $args)
    {
        return array_merge([&$arg], $args);
    }
}