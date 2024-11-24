<?php

declare(strict_types=1);

namespace Novara\Base\Tests\Test\Internal;

use Novara\Base\Internal\Call;
use Novara\Base\Internal\Map;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Map::class)]
#[UsesClass(Call::class)]
final class MapTest extends TestCase
{
    public static function replaceKeyProvider(): array
    {
        return [
            'empty' => [
                [
                    'test' => 'foo',
                ],
                [],
                'test',
                'foo',
            ],
            'no replacement' => [
                [
                    'foo' => 13,
                    'bar' => 37,
                    'test' => 1337,
                ],
                [
                    'foo' => 13,
                    'bar' => 37,
                ],
                'test',
                1337,
            ],
            'bar replacement' => [
                [
                    'foo' => 'ab',
                    'bar' => 'ef',
                ],
                [
                    'foo' => 'ab',
                    'bar' => 'cd',
                ],
                'bar',
                'ef',
            ],
        ];
    }

    public static function appendToKeyProvider(): array
    {
        return [
            'empty' => [
                [
                    'test' => ['foo'],
                ],
                [],
                'test',
                'foo',
            ],
            'no append' => [
                [
                    'foo' => [13],
                    'bar' => [37],
                    'test' => [1337],
                ],
                [
                    'foo' => [13],
                    'bar' => [37],
                ],
                'test',
                1337,
            ],
            'bar append' => [
                [
                    'foo' => ['ab'],
                    'bar' => ['cd', 'ef'],
                ],
                [
                    'foo' => ['ab'],
                    'bar' => ['cd'],
                ],
                'bar',
                'ef',
            ],
        ];
    }

    #[DataProvider('replaceKeyProvider')]
    public function testReplaceKey(array $expectException, array $input, string $key, mixed $replacement): void
    {
        self::assertSame($expectException, Map::replaceKey($input, $key, $replacement));
    }

    #[DataProvider('appendToKeyProvider')]
    public function testAppendToKey(array $expectException, array $input, string $key, mixed $append): void
    {
        self::assertSame($expectException, Map::appendToKey($input, $key, $append));
    }
}
