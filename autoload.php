<?php

use Novara\Base\Autoload\Loader;

require_once __DIR__ . '/src/Autoload/Loader.php';

Loader::register(new class {
    public const string PREFIX = '\Novara\Base';
    public const string DIRECTORY = __DIR__ . '/src';
});
