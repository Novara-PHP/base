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

# Installation

```bash
composer require novara/base "*"
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

# Why do this?

There a many good reasons to use Novara!

- You want functional programming? We **enforce** it!
- Stateless -> Exactly
- XDEBUG is just _too easy_ to use? Get rid of breakpoints!

# Jokes aside

I made this to prove I point. I have yet to find that point...

---

¹ "novarity" describes the complete absence of variables inside a PHP-Script.
