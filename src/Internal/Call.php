<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\PureStatic;

/**
 * Lord forgive me for my use of Variables.
 *
 * TODO: once tests are established find a way to refactor this into just using func_get_arg/-s, i have had scope issues
 */
final class Call extends PureStatic
{
    public static function spread(): bool
    {
        $result = 1;
        foreach (array_slice(func_get_args(), 1) as $callable) {
            $result &= (bool)($callable(func_get_arg(0)));
        }

        return (bool)$result;
    }
}
