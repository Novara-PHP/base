<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\PureStaticTrait;

final class Exception
{
    use PureStaticTrait;

    public static function throwIf(): false
    {
        if (func_get_arg(0)) {
            throw func_get_arg(1);
        }

        return false;
    }
}
