<?php

declare(strict_types=1);

namespace Novara\Base\Tests\Test\Internal;

use Novara\Base\Exception\StatelessBypassDetectedException;
use Novara\Base\Internal\Call;
use Novara\Base\Internal\Globals;
use Novara\Base\Novara;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Globals::class)]
#[UsesClass(Call::class)]
final class GlobalsTest extends TestCase
{
    public function test(): void
    {
        global $argc;
        global $argv;

        $_GET['foo'] = 'bar';
        $_POST['test'] = 1337;
        $_REQUEST = array_merge($_GET, $_POST);

        self::assertSame($GLOBALS, Novara::Globals::GLOBALS());
        self::assertSame($_SERVER, Novara::Globals::SERVER());
        self::assertSame($_GET, Novara::Globals::GET());
        self::assertSame($_POST, Novara::Globals::POST());
        self::assertSame($_FILES, Novara::Globals::FILES());
        self::assertSame($_COOKIE, Novara::Globals::COOKIE());
        self::assertSame($_REQUEST, Novara::Globals::REQUEST());
        self::assertSame($_ENV, Novara::Globals::ENV());
        self::assertSame($argc, Novara::Globals::argc());
        self::assertSame($argv, Novara::Globals::argv());

        self::expectException(StatelessBypassDetectedException::class);
        Novara::Globals::SESSION();
    }
}
