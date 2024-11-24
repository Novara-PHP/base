<?php

declare(strict_types=1);

namespace Novara\Base\Tests\Test\Internal;

use Novara\Base\Internal\Map;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Map::class)]
final class MapTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'empty' => [
                [],
                [],
                'test',
                'foo',
            ],
            'no replacement' => [
                [
                    'foo' => 13,
                    'bar' => 37,
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

    #[DataProvider('dataProvider')]
    public function testReplaceKey(array $expectException, array $input, string $key, mixed $replacement): void
    {
        self::assertSame($expectException, Map::replaceKey($input, $key, $replacement));
    }
}
