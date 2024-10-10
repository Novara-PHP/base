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

Enforce _novarity_ by replacing `require` and `include` with the library functions.

```php
Novara::Import::require(__DIR__ . '/autoload.php');
```

## Additional functions

Currently, Novara Base provides the following functions.

### throwIf

Throws an Exception if the condition evaluates to `false`,
returns `false` if no Exception was thrown.

```php
Novara::Exception::throwIf(
    UserService::getUserName() !== 'admin',
    new Exception('This can\'t be right!'),
);
```


# Why do this?

There a many good reasons to use Novara!

- You want functional programming? We **enforce** it!
- Stateless -> Exactly
- XDEBUG is just _too easy_ to use? Get rid of breakpoints!

# Jokes aside

I made this to prove I point. I have yet to find that point...
