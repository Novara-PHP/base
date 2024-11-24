<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\Novara;
use Novara\Base\PureStaticTrait;

class Map
{
    use PureStaticTrait;

    /**
     * Returns an array with changed key.
     */
    public static function replaceKey(): array
    {
        return Call::pass(
            [
                array_filter(
                    array_column(
                        array_map(
                            // 0: key
                            // 1: value
                            // 2: replacedKey
                            // 3: replacement
                            function() {
                                if (func_get_arg(0) !== func_get_arg(2)) {
                                    return [func_get_arg(0), func_get_arg(1)];
                                }

                                return [func_get_arg(0), func_get_arg(3)];
                            },
                            array_keys(func_get_arg(0)),
                            array_values(func_get_arg(0)),
                            array_fill(0, func_num_args(), func_get_arg(1)),
                            array_fill(0, func_num_args(), func_get_arg(2)),
                        ),
                        1,
                        0,
                    ),
                ),
                func_get_arg(1),
                func_get_arg(2),
            ],
            function (): array {
                if (array_key_exists(func_get_arg(0)[1], func_get_arg(0)[0])) {
                    return func_get_arg(0)[0];
                }

                return array_merge(func_get_arg(0)[0], [
                    func_get_arg(0)[1] => func_get_arg(0)[2],
                ]);
            }
        );
    }

    /**
     * Returns an array with key having array value extended by value.
     */
    public static function appendToKey(): array
    {
        return Call::pass(
            [
                array_filter(
                    array_column(
                        array_map(
                            function() {
                                if (func_get_arg(0) !== func_get_arg(2)) {
                                    return [func_get_arg(0), func_get_arg(1)];
                                }

                                return [func_get_arg(0), array_merge(func_get_arg(1), [func_get_arg(3)])];
                            },
                            array_keys(func_get_arg(0)),
                            array_values(func_get_arg(0)),
                            array_fill(0, func_num_args(), func_get_arg(1)),
                            array_fill(0, func_num_args(), func_get_arg(2)),
                        ),
                        1,
                        0,
                    ),
                ),
                func_get_arg(1),
                func_get_arg(2),
            ],
            function (): array {
                if (array_key_exists(func_get_arg(0)[1], func_get_arg(0)[0])) {
                    return func_get_arg(0)[0];
                }

                return array_merge(func_get_arg(0)[0], [
                    func_get_arg(0)[1] => [func_get_arg(0)[2]],
                ]);
            }
        );
    }
}
