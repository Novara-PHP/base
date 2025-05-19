<?php

// BUT ONLY IF YOU DO NOT USE THEM!

/**
 * @noinspection PhpIllegalPsrClassPathInspection
 */

namespace Novara\Base\Tests;

interface FooInterface
{
    public function bar(string $faz): string;
}

class Foo implements FooInterface
{
    public function bar(string $faz): string
    {
        // Dont use $faz directly!
        return 'Test: ' . func_get_arg(0);
    }
}
