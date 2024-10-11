<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\Exception\StatelessBypassDetectedException;
use Novara\Base\PureStatic;

/**
 * Readonly access to superglobals, argc, and argv.
 */
final class Globals extends PureStatic
{
    public static function GLOBALS(): array
    {
        return require __DIR__ . '/../purgatory/globals.php';
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

    /**
     * @throws StatelessBypassDetectedException
     *
     * @deprecated Do not even think about it!
     */
    public static function SESSION(): array
    {
        throw new StatelessBypassDetectedException('Why would you think this works?');
    }

    public static function REQUEST(): array
    {
        return self::GLOBALS()['_REQUEST'];
    }

    public static function ENV(): array
    {
        return self::GLOBALS()['_ENV'];
    }

    public static function argc(): int
    {
        return self::GLOBALS()['argc'];
    }

    public static function argv(): array
    {
        return self::GLOBALS()['argv'];
    }
}
