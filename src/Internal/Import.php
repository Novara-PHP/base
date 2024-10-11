<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\Exception\NovarityNotMetException;
use Novara\Base\PureStaticTrait;
use PhpToken;

final class Import
{
    use PureStaticTrait;

    /**
     * Throw an Exception if the included file uses any variables.
     *
     * Stateless > Stateful! Yes this is a joke.
     */
    public static function enforceNovarity(): false
    {
        // TODO: block eval if it contains any of the tokens
        // TODO: does this already block object properties? more tests -> more better
        // Use Exception directly without Novara:: prefix as to enable autoload
        return Exception::throwIf(
            count(
                array_filter(
                    PhpToken::tokenize(file_get_contents(func_get_arg(0))),
                    fn () => func_get_arg(0)->is([
                        T_VARIABLE,
                        T_GLOBAL,
                        T_ENCAPSED_AND_WHITESPACE,
                        T_CURLY_OPEN,
                        T_DOLLAR_OPEN_CURLY_BRACES,
                        T_NUM_STRING,
                        T_STRING_VARNAME,
                    ]),
                ),
            ) > 0,
            new NovarityNotMetException(sprintf(
                'File "%s" contains variables. Unforgivable!',
                func_get_arg(0),
            )),
        );
    }

    public static function include(): mixed
    {
        return self::enforceNovarity(func_get_arg(0)) ?: include func_get_arg(0);
    }

    public static function require(): mixed
    {
        return self::enforceNovarity(func_get_arg(0)) ?: include func_get_arg(0);
    }
}
