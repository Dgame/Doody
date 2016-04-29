<?php

namespace App\Wrapper;

/**
 * Class Wrapper
 * @package App\Wrapper
 */
abstract class Wrapper implements \ArrayAccess
{
    /**
     * @param string $method
     *
     * @return bool
     */
    protected final function allowChainFor(string $method)
    {
        if (preg_match('#^(?:is|to|as).+?#i', $method)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $value
     *
     * @return StringWrapper
     */
    public static function string(string $value)
    {
        return new StringWrapper($value);
    }

    /**
     * @param array ...$values
     *
     * @return ArrayWrapper
     */
    public static function vector(...$values)
    {
        return new ArrayWrapper($values);
    }

    /**
     * @param array ...$values
     *
     * @return ArrayWrapper
     */
    public static function dict(...$values)
    {
        $dict = [];
        foreach ($values as $value) {
            $dict[trim($value)] = true;
        }

        return new ArrayWrapper($dict);
    }

    /**
     * @param $value
     *
     * @return ArrayWrapper|StringWrapper
     * @throws \Exception
     */
    public static function of($value)
    {
        if (self::isString($value)) {
            return new StringWrapper($value);
        }

        if (self::isArray($value)) {
            return new ArrayWrapper($value);
        }

        throw new \Exception('Unbekannter oder nicht unterstützter Typ');
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isArray($value)
    {
        return is_array($value);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function isString($value)
    {
        return is_string($value);
    }
}