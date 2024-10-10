<?php

namespace Novara\Base\Internal;

use Novara\Base\PureStatic;

/**
 * @template T
 */
final class Exception extends PureStatic
{
    /**
     * @param $condition bool
     * @param $throwable T
     * @return false
     *
     * @throws T
     *
     * @noinspection PhpDocSignatureInspection
     */
    public static function throwIf(): false
    {
        if (func_get_arg(0)) {
            throw func_get_arg(1);
        }

        return false;
    }
}
