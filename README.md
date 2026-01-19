# Lettermint Laravel (PHP 8.0+ Fork)

This is a 1-on-1 port of [lettermint/lettermint-laravel](https://github.com/lettermint/lettermint-laravel) version 1.5.2, modified to support PHP 8.0+.

## Requirements

- PHP 8.0 or higher
- Laravel 9 or higher

## Why this fork?

The official `lettermint/lettermint-laravel` package requires PHP 8.2+. This fork backports the package to support PHP 8.0+ for projects that cannot upgrade to PHP 8.2.

## Installation

Since this package is not published on Packagist, you need to add the repository to your `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/joshuadegier/lettermint-laravel-php8"
        }
    ]
}
```

Then require the package:

```bash
composer require lettermint/lettermint-laravel-php8:dev-main
```

Or add it directly to your `composer.json`:

```json
{
    "require": {
        "lettermint/lettermint-laravel-php8": "dev-main"
    }
}
```

## Documentation

For full documentation, please refer to the official package documentation at:
https://github.com/lettermint/lettermint-laravel

All features and configuration options are identical to the official package.

## Changes from official package

- Removed PHP 8.2 `readonly class` declarations
- Converted PHP 8.1 `enum` to a class-based implementation
- Removed PHP 8.1 `readonly` property modifiers
- Lowered PHP requirement from `^8.2` to `^8.0`

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
