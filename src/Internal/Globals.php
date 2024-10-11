<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\PureStatic;

/**
 * Readonly access to superglobals, $argc, and $argv.
 */
final class Globals extends PureStatic
{
    private static function deepClone(): array
    {
        return array_map(
            fn () => is_array(func_get_arg(0))
                ? self::deepClone(func_get_arg(0))
                : (
                    is_object(func_get_arg(0))
                        ? clone func_get_arg(0)
                        : func_get_arg(0)
                ),
            func_get_arg(0),
        );
    }

    public static function GLOBALS(): array
    {
        // Wish we would be able to have zero variable access, what a shame...
        // TODO: get_defined_vars() in the global scope should work!
        return self::deepClone($GLOBALS);
    }

    public static function SERVER(): array
    {
        return self::GLOBALS()['_SERVER'];
    }

    public static function GET(): array
    {
        return self::GLOBALS()['_GET'];
    }

    public static function POST(): array
    {
        return self::GLOBALS()['_POST'];
    }

    public static function FILES(): array
    {
        return self::GLOBALS()['_FILES'];
    }

    public static function COOKIE(): array
    {
        return self::GLOBALS()['_COOKIE'];
    }

    public static function SESSION(): array
    {
        return self::GLOBALS()['_SESSION'];
    }

    public static function REQUEST(): array
    {
        return self::GLOBALS()['_REQUEST'];
    }

    public static function ENV(): array
    {
        return self::GLOBALS()['_ENV'];
    }

    public static function argc(): array
    {
        return self::GLOBALS()['argc'];
    }

    public static function argv(): array
    {
        return self::GLOBALS()['argv'];
    }
}
