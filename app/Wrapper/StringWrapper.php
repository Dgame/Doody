<?php

namespace App\Wrapper;

use App\Wrapper\Mapping\Mapping;
use App\Wrapper\Mapping\StringMapping;
use App\Wrapper\Method\Method;

/**
 * Class StringWrapper
 * @package App\Wrapper
 */
final class StringWrapper extends Wrapper
{
    /**
     * @var null|string
     */
    private $_value = null;

    /**
     * StringWrapper constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->_value = $value;
    }

    /**
     * @return null|string
     */
    public function asString()
    {
        return $this->_value;
    }

    /**
     * @param string $name
     * @param array  $args
     *
     * @return mixed
     */
    public function __call(string $name, array $args)
    {
        $method = Mapping::Instance(StringMapping::class)->resolveMethod($name);
        $class  = Mapping::Instance(StringMapping::class)->getMethodCall($method);
        $args   = Method::Instance($class)->apply(ref($this->_value), $args);
        $result = Method::Instance($class)->call($method, $args);

        if ($this->allowChainFor($name) && self::isString($result)) {
            return new self($result);
        }

        return $result;
    }

    /**
     * @return string
     */
    public function front()
    {
        return substr($this->asString(), 0, 1);
    }

    /**
     * @return string
     */
    public function back()
    {
        return substr($this->asString(), -1);
    }

    /**
     * @param array $args
     *
     * @return bool
     */
    public function in(array $args)
    {
        return array_key_exists($this->asString(), $args);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->_value);
    }

    /**
     * @param string $str
     */
    public function append(string $str)
    {
        $this->_value .= $str;
    }

    /**
     * @param string $str
     */
    public function prepend(string $str)
    {
        $this->_value = $str . $this->_value;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->_value;
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
        return array_key_exists($offset, $this->_value);
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
        return $this->_value[$offset];
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
            $this->_value[] = $value;
        } else {
            $this->_value[$offset] = $value;
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
        unset($this->_value[$offset]);
    }
}