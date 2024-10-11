<?php

declare(strict_types=1);

namespace Novara\Base\Internal;

use Novara\Base\Exception\NovarityNotMetException;
use Novara\Base\Novara;
use Novara\Base\PureStatic;
use PhpToken;

final class Import extends PureStatic
{
    /**
     * Throw an Exception if the included file uses any variables.
     *
     * Stateless > Stateful! Yes this is a joke.
     */
    private static function containsVariables(): false
    {
        // TODO: block eval if it contains any of the tokens
        // TODO: does this already block object properties? more tests -> more better
        return Novara::Exception::throwIf(
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
        return self::containsVariables(func_get_arg(0)) ?: include func_get_arg(0);
    }

    public static function require(): mixed
    {
        return self::containsVariables(func_get_arg(0)) ?: include func_get_arg(0);
    }
}
