<?php

declare(strict_types=1);

namespace Novara\Base\Tests\Test\Internal;

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
                __DIR__ . '/../../Fixture/good_stuff_without_dollar_signs.php',
            ],
            'with variable include' => [
                true,
                'include',
                __DIR__ . '/../../Fixture/the_worst_you_can_do.php',
            ],
            'no variable require' => [
                false,
                'require',
                __DIR__ . '/../../Fixture/good_stuff_without_dollar_signs.php',
            ],
            'with variable require' => [
                true,
                'require',
                __DIR__ . '/../../Fixture/the_worst_you_can_do.php',
            ],
            'parameters with func_get_arg' => [
                false,
                'require',
                __DIR__ . '/../../Fixture/parameters_are_a_necessary_evil.php'
            ],
            'evil class' => [
                true,
                'require',
                __DIR__ . '/../../Fixture/evil_class.php',
            ],
            'evil static class' => [
                true,
                'require',
                __DIR__ . '/../../Fixture/evil_static_class.php',
            ],
            'evil bypass' => [
                true,
                'require',
                __DIR__ . '/../../Fixture/evil_bypass.php',
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
