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
}
