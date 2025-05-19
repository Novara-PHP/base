<?php

/**
 * @noinspection PhpIllegalPsrClassPathInspection
 */

namespace Novara\Base\Tests;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class EvilClass
{
    public function test(string $in): string
    {
        $this->out = func_get_arg(0);

        return $this->out;
    }
}
