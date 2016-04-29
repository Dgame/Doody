<?php

namespace App\Wrapper\Method;

/**
 * Class Method
 * @package App\Wrapper\Method
 */
abstract class Method
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Method constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param string $class
     *
     * @return $this
     * @throws \Exception
     */
    public static function Instance(string $class)
    {
        if (!array_key_exists($class, self::$instances)) {
            enforce(is_subclass_of($class, self::class), 'Klasse %s muss von Method abgeleitet sein', $class);

            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

    /**
     * @param       $arg
     * @param array $args
     *
     * @return mixed
     */
    abstract public function apply(&$arg, array $args);

    /**
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function call(string $method, array $args)
    {
        return call_user_func_array($method, $args);
    }
}