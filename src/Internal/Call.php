<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\PureStaticTrait;

/**
 * Lord forgive me for my use of Variables.
 */
final class Call
{
    use PureStaticTrait;

    /**
     * Calls the functions passed as the >= 2nd parameters with the first parameter.
     */
    public static function spread(): bool
    {
        return !in_array(false, array_map(
            fn () => (bool)func_get_arg(0)(func_get_arg(1)),
            array_slice(func_get_args(), 1),
            array_fill(0, func_num_args() - 1, func_get_arg(0)),
        ));
    }

    /**
     * Access func_get_args() with names rather than indices.
     */
    public static function args(): object
    {
        return (object)array_combine(
            func_get_arg(0),
            func_get_arg(1),
        );
    }
}
