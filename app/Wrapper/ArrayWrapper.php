<?php

namespace App\Wrapper;

use App\Wrapper\Mapping\ArrayMapping;
use App\Wrapper\Mapping\Mapping;
use App\Wrapper\Method\Method;

/**
 * Class ArrayWrapper
 * @package App\Wrapper
 */
final class ArrayWrapper extends Wrapper implements \Iterator
{
    /**
     * @var array
     */
    private $_values = [];

    /**
     * ArrayWrapper constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $this->_values = $values;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return $this->_values;
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $name, array $args)
    {
        $method = Mapping::Instance(ArrayMapping::class)->resolveMethod($name);
        $class  = Mapping::Instance(ArrayMapping::class)->getMethodCall($method);
        $args   = Method::Instance($class)->apply(ref($this->_values), $args);
        $result = Method::Instance($class)->call($method, $args);

        if ($this->allowChainFor($name) && self::isArray($result)) {
            return new self($result);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->_values);
    }

    /**
     * @param callable $callback
     */
    public function each(callable $callback)
    {
        foreach ($this->_values as $key => &$value) {
            $callback($key, $value);
        }
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_values);
    }

    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->_values[$offset];
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->_values[] = $value;
        } else {
            $this->_values[$offset] = $value;
        }
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->_values[$offset]);
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return current($this->_values);
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        next($this->_values);
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return key($this->_values);
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return array_key_exists($this->key(), $this->_values);
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        reset($this->_values);
    }
}