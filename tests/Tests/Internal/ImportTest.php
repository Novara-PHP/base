<?php

namespace Novara\Base\Tests\Tests\Internal;

use Novara\Base\Exception\NovarityNotMetException;
use Novara\Base\Internal\Exception;
use Novara\Base\Internal\Import;
use Novara\Base\Novara;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Import::class)]
#[UsesClass(Exception::class)]
final class ImportTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            'no variable include' => [
                false,
                'include',
                __DIR__ . '/../../Fixtures/good_stuff_without_dollar_signs.php',
            ],
            'with variable include' => [
                true,
                'include',
                __DIR__ . '/../../Fixtures/the_worst_you_can_do.php',
            ],
            'no variable require' => [
                false,
                'require',
                __DIR__ . '/../../Fixtures/good_stuff_without_dollar_signs.php',
            ],
            'with variable require' => [
                true,
                'require',
                __DIR__ . '/../../Fixtures/the_worst_you_can_do.php',
            ],
        ];
    }

    #[DataProvider('dataProvider')]
    public function testIncludeAndRequire(bool $expectException, string $method, string $filename): void
    {
        if ($expectException) {
            self::expectException(NovarityNotMetException::class);
        }

        ob_start();
        try {
            if ($method === 'require') {
                Novara::Import::require($filename);
            } else {
                Novara::Import::include($filename);
            }
        } finally {
            ob_end_clean();
        }

        if (!$expectException) {
            self::assertTrue(true);
        }
    }
}
