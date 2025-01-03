<?php

declare(strict_types=1);

// phpcs:disable Generic.NamingConventions.UpperCaseConstantName

namespace Novara\Base;

use Novara\Base\Internal\Call;
use Novara\Base\Internal\Exception;
use Novara\Base\Internal\Globals;
use Novara\Base\Internal\Import;
use Novara\Base\Internal\Map;

final class Novara
{
    use PureStaticTrait;

    public const string Call = Call::class;
    public const string Exception = Exception::class;
    public const string Globals = Globals::class;
    public const string Import = Import::class;
    public const string Map = Map::class;
}
