<?php

/**
 * My Kryptonite, GLOBALS.
 *
 * Unavoidable, undesirable, undermining the divine mission.
 */

// @codeCoverageIgnoreStart
return (new class {
    public static function deepClone(): array
    {
        // Making sure GLOBALS are immutable and cannot be abused
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
})::deepClone($GLOBALS);
// @codeCoverageIgnoreEnd
