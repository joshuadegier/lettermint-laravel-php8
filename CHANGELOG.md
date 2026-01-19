# Changelog

All notable changes to `lettermint-laravel-php8` will be documented in this file.

## 1.5.2-php8 - Initial Fork

This is a PHP 8.0+ compatible fork of [lettermint/lettermint-laravel](https://github.com/lettermint/lettermint-laravel) version 1.5.2.

### Changes from upstream

- Converted PHP 8.1 `enum WebhookEventType` to a class-based implementation
- Removed PHP 8.2 `readonly class` declarations from all Data classes
- Removed PHP 8.1 `readonly` property modifiers from Event classes
- Lowered PHP requirement from `^8.2` to `^8.0`
- Removed CI/CD workflows, test suite, and code formatting configuration

For the full changelog of the upstream package, see:
https://github.com/lettermint/lettermint-laravel/blob/main/CHANGELOG.md
