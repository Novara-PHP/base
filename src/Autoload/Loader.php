<?php

namespace Novara\Base\Autoload;

use Error;
use Novara\Base\Internal\Exception;
use Novara\Base\Internal\Import;
use Novara\Base\PureStaticTrait;

// Import the novarity enforcing importer itself

// Require dependencies of the importer
(new class () {
    // Using a class to not have the DEPENDENCIES in global scope
    const array DEPENDENCIES = [
        __DIR__ . '/../PureStaticTrait.php',
        __DIR__ . '/../Internal/Import.php',
        __DIR__ . '/../Exception/NovaraException.php',
        __DIR__ . '/../Exception/NovarityNotMetException.php',
        __DIR__ . '/../Internal/Exception.php',
    ];

    public static function load(): void
    {
        array_map(fn () => require_once func_get_arg(0), self::DEPENDENCIES);

        // now that the Import is available, we can retroactively proof novarity
//        array_map(Import::enforceNovarity(...), self::DEPENDENCIES);
    }
})::load();

/**
 * @codeCoverageIgnore
 */
final class Loader
{
    use PureStaticTrait;

    /**
     * Registers a new autoloader from a passed configuration object.
     *
     * The configuration object must define following constants:
     *  PREFIX: the namespace prefix
     *  DIRECTORY: the directory from which to load
     */
    public static function register(): void
    {
        try {
            Exception::throwIf(
                !is_object(func_get_arg(0))
                    || !is_string(func_get_arg(0)::PREFIX)
                    || !is_string(func_get_arg(0)::DIRECTORY),
                fn () => die('Not a valid autoload configuration object.'),
            ) || spl_autoload_register(
                (function () {
                    /** @noinspection All */

                    // As much as it pains me to use $this, it only is used to reference CONSTANT values, not variables.
                    return str_starts_with(func_get_arg(0), $this::PREFIX)
                        ?: file_exists(substr(func_get_arg(0), strlen($this::PREFIX)))
                            ?: require $this::DIRECTORY . DIRECTORY_SEPARATOR . str_replace(
                                '\\',
                                DIRECTORY_SEPARATOR,
                                substr(func_get_arg(0), strlen($this::PREFIX))
                            ) . '.php';
                })(...)->bindTo(func_get_arg(0))
            );
        } catch (Error $error) {
            die(
                <<<EOF
                    Did you forget to set PREFIX and DIRECTORY?
                    $error
                    
                    EOF
            );
        }
    }
}
