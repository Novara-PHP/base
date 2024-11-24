<h1 align="center">
Novara
</h1>

<div align="center">

![](https://github.com/Novara-PHP/base/actions/workflows/tests.yml/badge.svg)
![](https://raw.githubusercontent.com/Novara-PHP/base/image-data/coverage.svg)
![](https://img.shields.io/github/v/release/Novara-PHP/base)
[![License: MIT](https://img.shields.io/github/license/Novara-PHP/base)](../../raw/main/LICENSE.txt)

</div>

<div align="center">

[//]: # (<img src="readme/1.gif" width="300">)

Variables? Disgusting!

</div>

Say "No!" to variables! Don't introduce state to your code.

> 9/10 Variables can be replaced with functional programming.
> I say let's ignore the remaining one and just do it!
>
> &mdash; <cite>Someone Somewhere</cite>

This is an exercise in pain tolerance. 

# Installation

```bash
composer require novara/base
```

# Usage

## Superglobals

Superglobals (including `$GLOBALS`) can be accessed read-only.

```php
// $GLOBALS
Novara::Globals::GLOBALS();

// $_GET
Novara::Globals::GET();

// ...
```

## include() and require()

Enforce _novarity¹_ by replacing `require` and `include` with the library functions.

```php
Novara::Import::require(__DIR__ . '/autoload.php');
```

> ⓘ You can also autoload via the `\Novara\Base\Autoloader\Loader` class.
> See [composer.json](composer.json) and [autoload.php](autoload.php).

## throwIf()

Throws an Exception if the condition evaluates to `true`.
Returns `false` if no Exception was thrown.

```php
Novara::Exception::throwIf(
    UserService::getUserName() !== 'admin',
    new Exception('This can\'t be right!'),
);
```

## spread()

Reuse a value across multiple calls without creating a dedicated variable.

```php
// This variable infested block:
$unnecessaryVariable = SomeService::getWhatever(); // Buffer to not call getWhatever() thrice
doAThing($unnecessaryVariable);
doAnotherThing($unnecessaryVariable);
if ($unnecessaryVariable > 100) {
    echo 'Wow!';
}

// becomes utter beauty:
Novara::Call::spread(
    SomeService::getWhatever(),
    doAThing(...),
    doAnotherThing(...),
    fn () => func_get_arg(0) > 100 && print 'Wow!',
);
```

> ⓘ `spread()` will return `true` if **all** calls return a truthy value, otherwise `false`.

## pass()

`Novara::Call::pass()` re-scopes a value as parameter of a function call.
Passing allows returning the value from the internal call.

```php
Novara::Call::pass(
    MyService::calculateSomethingComplex('foo', 123, func_get_arg(0)),
    fn () => someFunction(func_get_arg(0)) ?: anotherFunction(func_get_arg(0)),
)
```

## args()

The `Novara::Call::args()` function allows you to ensure novarity yet still have named arguments.

```php
Novara::Call::args(
    [
        'name',
        'age',
    ],
    func_get_args(),
)->age === ...
```

This can be combined with passing or spreading.

```php
// Reuse args through passing
return Novara::Call::pass(
    Novara::Call::args(
        [
            'name',
            'age',
        ],
        func_get_args(),
    ),
    fn () => 'Name: ' . func_get_arg(0)->name . '; Age: ' . func_get_arg(0)->age,
);

// Share the args through spreading
return Novara::Call::spread(
    Novara::Call::args(
        [
            'name',
            'age',
        ],
        func_get_args(),
    ),
    function () {
        ... func_get_arg(0)->name ...
    },
    function () {
        ... func_get_arg(0)->age ...
    },
);
```

## replaceKey()

Copy-on-write with changed value by key of passed array.

```php
Novara::Map::replaceKey(
    [
        'foo' => 13,
        'bar' => 14,
    ],
    'bar',
    37,
);

// results in
[
    'foo' => 13,
    'bar' => 37,
]
```

## appendToKey()

Copy-on-write with appended value by key of passed array.

Array must be multidimensional.

```php
Novara::Map::appendToKey(
    [
        'foo' => [1234],
        'bar' => [13],
    ],
    'bar',
    37,
);

// results in
[
    'foo' => [1234],
    'bar' => [13, 37],
]
```


# Why do this?

There a many good reasons to use Novara!

- You want functional programming? We **enforce** it!
- Stateless -> Exactly
- XDEBUG is just _too easy_ to use? Get rid of breakpoints!
- Your keyboard conveniently broke in a specific way, not letting you use the Dollar (`$`) symbol

# Jokes aside

I made this to prove I point. I have yet to find that point...

---

¹ "novarity" describes the complete absence of variables inside a PHP-Script.
