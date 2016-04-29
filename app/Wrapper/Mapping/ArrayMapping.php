<?php

namespace App\Wrapper\Mapping;

use App\Wrapper\Method\FirstArgumentMethod;
use App\Wrapper\Method\LastArgumentMethod;
use App\Wrapper\Method\RefArgumentMethod;

/**
 * Class ArrayMapping
 * @package App\Wrapper\Mapping
 */
final class ArrayMapping extends Mapping
{
    /**
     * @var array
     */
    private static $MethodArgumentClass = [
        'array_change_key_case'   => FirstArgumentMethod::class,
        'array_chunk'             => FirstArgumentMethod::class,
        'array_combine'           => FirstArgumentMethod::class,
        'array_count_values'      => FirstArgumentMethod::class,
        'array_diff_assoc'        => FirstArgumentMethod::class,
        'array_diff_key'          => FirstArgumentMethod::class,
        'array_diff_uassoc'       => FirstArgumentMethod::class,
        'array_diff_ukey'         => FirstArgumentMethod::class,
        'array_diff'              => FirstArgumentMethod::class,
        'array_fill_keys'         => FirstArgumentMethod::class,
        'array_filter'            => FirstArgumentMethod::class,
        'array_flip'              => FirstArgumentMethod::class,
        'array_intersect_assoc'   => FirstArgumentMethod::class,
        'array_intersect_key'     => FirstArgumentMethod::class,
        'array_intersect_uassoc'  => FirstArgumentMethod::class,
        'array_intersect_ukey'    => FirstArgumentMethod::class,
        'array_intersect'         => FirstArgumentMethod::class,
        'array_keys'              => FirstArgumentMethod::class,
        'array_merge_recursive'   => FirstArgumentMethod::class,
        'array_merge'             => FirstArgumentMethod::class,
        'array_pad'               => FirstArgumentMethod::class,
        'array_reverse'           => FirstArgumentMethod::class,
        'array_slice'             => FirstArgumentMethod::class,
        'array_sum'               => FirstArgumentMethod::class,
        'array_udiff_assoc'       => FirstArgumentMethod::class,
        'array_udiff_uassoc'      => FirstArgumentMethod::class,
        'array_udiff'             => FirstArgumentMethod::class,
        'array_uintersect_assoc'  => FirstArgumentMethod::class,
        'array_uintersect_uassoc' => FirstArgumentMethod::class,
        'array_uintersect'        => FirstArgumentMethod::class,
        'array_unique'            => FirstArgumentMethod::class,
        'array_values'            => FirstArgumentMethod::class,
        'count'                   => FirstArgumentMethod::class,
        'extract'                 => FirstArgumentMethod::class,
        'array_fill'              => LastArgumentMethod::class,
        'array_map'               => LastArgumentMethod::class,
        'array_search'            => LastArgumentMethod::class,
        'implode'                 => LastArgumentMethod::class,
        'in_array'                => LastArgumentMethod::class,
        'array_key_exists'        => LastArgumentMethod::class,
        'array_shift'             => RefArgumentMethod::class,
        'array_pop'               => RefArgumentMethod::class,
        'array_push'              => RefArgumentMethod::class,
        'array_unshift'           => RefArgumentMethod::class,
        'array_splice'            => RefArgumentMethod::class,
        'array_walk_recursive'    => RefArgumentMethod::class,
        'array_walk'              => RefArgumentMethod::class,
        'arsort'                  => RefArgumentMethod::class,
        'asort'                   => RefArgumentMethod::class,
        'krsort'                  => RefArgumentMethod::class,
        'ksort'                   => RefArgumentMethod::class,
        'natcasesort'             => RefArgumentMethod::class,
        'natsort'                 => RefArgumentMethod::class,
        'rsort'                   => RefArgumentMethod::class,
        'shuffle'                 => RefArgumentMethod::class,
        'sort'                    => RefArgumentMethod::class,
        'uasort'                  => RefArgumentMethod::class,
        'uksort'                  => RefArgumentMethod::class,
        'usort'                   => RefArgumentMethod::class
    ];

    /**
     * @var array
     */
    private static $Aliase = [
        'contains' => 'in_array',
        'hasKey'   => 'array_key_exists'
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
        return ['array_'];
    }
}