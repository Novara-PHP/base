<?php

namespace Novara\Base\Tests\Tests\Internal;

use Exception;
use Novara\Base\Novara;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Novara\Base\Internal\Exception::class)]
final class ExceptionTest extends TestCase
{
    public function testThrowIfTrue(): void
    {
        $this->expectException(Exception::class);

        Novara::Exception::throwIf(true, new Exception('Test'));
    }

    public function testThrowIfFalse(): void
    {
        Novara::Exception::throwIf(false, new Exception('Test'));

        self::assertTrue(true);
    }
}
