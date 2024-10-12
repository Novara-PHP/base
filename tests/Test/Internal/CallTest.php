<?php

declare(strict_types=1);

namespace Novara\Base\Tests\Test\Internal;

use Novara\Base\Internal\Call;
use Novara\Base\Novara;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Call::class)]
final class CallTest extends TestCase
{
    public function testSpread(): void
    {
        $calls = [false, false, false];

        self::assertFalse(
            Novara::Call::spread(
                'foo',
                function (string $input) use (&$calls) {
                    return $calls[0] = $input === 'foo';
                },
                function (string $input) use (&$calls) {
                    return $calls[1] = $input === 'bar';
                },
                function (string $input) use (&$calls) {
                    return $calls[2] = $input !== 'whatever';
                },
            ),
        );
        self::assertSame([true, false, true], $calls);

        // If everything returns true, spread returns true!
        self::assertTrue(
            Novara::Call::spread(
                12345,
                function () use (&$calls) {
                    return true;
                },
                function () use (&$calls) {
                    return true;
                },
                function () use (&$calls) {
                    return true;
                },
            ),
        );
    }

    public function testArgs(): void
    {
        $callable = function () {
            return Novara::Call::args(
                [
                    'foo',
                ],
                func_get_args(),
            )->foo;
        };

        self::assertSame('1234', $callable('1234'));
        self::assertSame('a', $callable('a'));
        self::assertSame(12, $callable(12));

        $resultName = $resultAge = null;
        $callable = function () use (&$resultName, &$resultAge) {
            return Novara::Call::spread(
                Novara::Call::args(
                    [
                        'name',
                        'age',
                    ],
                    func_get_args(),
                ),
                function () use (&$resultName) {
                    $resultName = func_get_arg(0)->name;
                },
                function () use (&$resultAge) {
                    $resultAge = func_get_arg(0)->age;
                },
            );
        };

        $callable('Mark', 27);
        self::assertSame('Mark', $resultName);
        self::assertSame(27, $resultAge);
    }

    public static function testPass(): void
    {
        $callable = function () {
            return Novara::Call::pass(
                Novara::Call::args(
                    [
                        'name',
                        'age',
                    ],
                    func_get_args(),
                ),
                fn () => 'Name: ' . func_get_arg(0)->name . '; Age: ' . func_get_arg(0)->age,
            );
        };

        self::assertSame('Name: Michael; Age: 29', $callable('Michael', '29'));
        self::assertSame('Name: Andrew; Age: 21', $callable('Andrew', '21'));
    }
}
