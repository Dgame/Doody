<?php

namespace App\Wrapper\Mapping;

use App\Wrapper\Method\FirstArgumentMethod;
use App\Wrapper\Method\LastArgumentMethod;

/**
 * Class StringMapping
 * @package App\Wrapper\Mapping
 */
final class StringMapping extends Mapping
{
    /**
     * @var array
     */
    private static $MethodArgumentClass = [
        'addslashes'              => FirstArgumentMethod::class,
        'bin2hex'                 => FirstArgumentMethod::class,
        'chunk_split'             => FirstArgumentMethod::class,
        'crypt'                   => FirstArgumentMethod::class,
        'html_entity_decode'      => FirstArgumentMethod::class,
        'htmlentities'            => FirstArgumentMethod::class,
        'htmlspecialchars_decode' => FirstArgumentMethod::class,
        'htmlspecialchars'        => FirstArgumentMethod::class,
        'lcfirst'                 => FirstArgumentMethod::class,
        'ltrim'                   => FirstArgumentMethod::class,
        'md5'                     => FirstArgumentMethod::class,
        'nl2br'                   => FirstArgumentMethod::class,
        'quoted_printable_decode' => FirstArgumentMethod::class,
        'quoted_printable_encode' => FirstArgumentMethod::class,
        'quotemeta'               => FirstArgumentMethod::class,
        'rtrim'                   => FirstArgumentMethod::class,
        'sha1'                    => FirstArgumentMethod::class,
        'sprintf'                 => FirstArgumentMethod::class,
        'str_pad'                 => FirstArgumentMethod::class,
        'str_repeat'              => FirstArgumentMethod::class,
        'str_rot13'               => FirstArgumentMethod::class,
        'str_shuffle'             => FirstArgumentMethod::class,
        'strip_tags'              => FirstArgumentMethod::class,
        'stripcslashes'           => FirstArgumentMethod::class,
        'stripslashes'            => FirstArgumentMethod::class,
        'strpbrk'                 => FirstArgumentMethod::class,
        'stristr'                 => FirstArgumentMethod::class,
        'strrev'                  => FirstArgumentMethod::class,
        'strstr'                  => FirstArgumentMethod::class,
        'strtok'                  => FirstArgumentMethod::class,
        'strtolower'              => FirstArgumentMethod::class,
        'strtoupper'              => FirstArgumentMethod::class,
        'strtr'                   => FirstArgumentMethod::class,
        'substr_replace'          => FirstArgumentMethod::class,
        'substr'                  => FirstArgumentMethod::class,
        'trim'                    => FirstArgumentMethod::class,
        'ucfirst'                 => FirstArgumentMethod::class,
        'ucwords'                 => FirstArgumentMethod::class,
        'vsprintf'                => FirstArgumentMethod::class,
        'wordwrap'                => FirstArgumentMethod::class,
        'count_chars'             => FirstArgumentMethod::class,
        'hex2bin'                 => FirstArgumentMethod::class,
        'strlen'                  => FirstArgumentMethod::class,
        'strpos'                  => FirstArgumentMethod::class,
        'substr_compare'          => FirstArgumentMethod::class,
        'substr_count'            => FirstArgumentMethod::class,
        'str_ireplace'            => LastArgumentMethod::class,
        'str_replace'             => LastArgumentMethod::class,
        'explode'                 => LastArgumentMethod::class,
    ];

    /**
     * @var array
     */
    private static $Aliase = [
        'indexOf'   => 'strpos',
        'length'    => 'strlen',
        'substring' => 'substr',
        'reverse'   => 'strrev',
    ];

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasMapping(string $name)
    {
        return array_key_exists($name, self::$MethodArgumentClass);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function getMapping(string $name)
    {
        return self::$MethodArgumentClass[$name];
    }

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function hasAlias(string $alias)
    {
        return array_key_exists($alias, self::$Aliase);
    }

    /**
     * @param string $alias
     *
     * @return string
     */
    public function getAlias(string $alias)
    {
        return self::$Aliase[$alias];
    }

    /**
     * @return array
     */
    public function getPrefixes()
    {
        return ['str', 'str_'];
    }
}