<?php

namespace App\Wrapper\Mapping;

/**
 * Class Mapping
 * @package App\Wrapper\Mapping
 */
abstract class Mapping
{
    /**
     * @var array
     */
    private static $instances = [];

    /**
     * Mapping constructor.
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
            enforce(is_subclass_of($class, self::class), 'Klasse %s muss von Mapping abgeleitet sein', $class);

            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    abstract public function hasMapping(string $name);

    /**
     * @param string $name
     *
     * @return mixed
     */
    abstract public function getMapping(string $name);

    /**
     * @param string $alias
     *
     * @return mixed
     */
    abstract public function hasAlias(string $alias);

    /**
     * @param string $alias
     *
     * @return mixed
     */
    abstract public function getAlias(string $alias);

    /**
     * @param string $alias
     *
     * @return mixed|string
     * @throws \Exception
     */
    public final function resolveMethod(string $alias)
    {
        $name = $this->resolveAlias($alias);
        if ($this->hasMapping($name)) {
            return $name;
        }

        $method = $this->searchForMethod($name);
        if ($method === null) {
            $name   = preg_replace('#([A-Z])#', '_$1', $name);
            $method = $this->searchForMethod($name);
        }

        if ($method !== null) {
            return $method;
        }

        throw new \Exception('Keine solche Methode gefunden: ' . $name);
    }

    /**
     * @param string $name
     *
     * @return null|string
     */
    private function searchForMethod(string $name)
    {
        $name = strtolower($name);
        if (function_exists($name) && $this->hasMapping($name)) {
            return $name;
        }

        foreach ($this->getPrefixes() as $prefix) {
            $method = $prefix . $name;
            if (function_exists($method) && $this->hasMapping($method)) {
                return $method;
            }
        }

        return null;
    }

    /**
     * @param string $alias
     *
     * @return mixed
     * @throws \Exception
     */
    public final function getMethodCall(string $alias)
    {
        $name = $this->resolveAlias($alias);
        if ($this->hasMapping($name)) {
            return $this->getMapping($name);
        }

        throw new \Exception('Kein MethodenCall gefunden für ' . $alias);
    }

    /**
     * @param string $alias
     *
     * @return string
     */
    public final function resolveAlias(string $alias)
    {
        if ($this->hasAlias($alias)) {
            return $this->getAlias($alias);
        }

        return $alias;
    }

    /**
     * @return mixed
     */
    abstract public function getPrefixes();
}