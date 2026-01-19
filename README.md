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

## Configuration

### 1. Publish the config file (optional)

```bash
php artisan vendor:publish --tag="lettermint-config"
```

This creates a `config/lettermint.php` file.

### 2. Set your API token

Add your Lettermint API token to your `.env` file:

```env
LETTERMINT_TOKEN=your-lettermint-token
```

### 3. Add the mail transport

In your `config/mail.php`, add the Lettermint mailer to the `mailers` array:

```php
'mailers' => [
    // ... other mailers

    'lettermint' => [
        'transport' => 'lettermint',
    ],
],
```

### 4. Add the service configuration

In your `config/services.php`, add:

```php
'lettermint' => [
    'token' => env('LETTERMINT_TOKEN'),
],
```

### 5. Set as default mailer (optional)

To use Lettermint as your default mailer, update your `.env`:

```env
MAIL_MAILER=lettermint
```

## Using Routes

If you want to specify a Lettermint route for a mailer, add the `route_id` option:

```php
'lettermint' => [
    'transport' => 'lettermint',
    'route_id' => env('LETTERMINT_ROUTE_ID'),
],
```

## Multiple Mailers

You can configure multiple mailers with different routes:

```php
'mailers' => [
    'lettermint_marketing' => [
        'transport' => 'lettermint',
        'route_id' => env('LETTERMINT_MARKETING_ROUTE_ID'),
    ],
    'lettermint_transactional' => [
        'transport' => 'lettermint',
        'route_id' => env('LETTERMINT_TRANSACTIONAL_ROUTE_ID'),
    ],
],
```

Then use them:

```php
Mail::mailer('lettermint_marketing')->to($user)->send(new MarketingEmail());
Mail::mailer('lettermint_transactional')->to($user)->send(new TransactionalEmail());
```

## Webhooks

To receive webhooks from Lettermint, add your webhook secret to `.env`:

```env
LETTERMINT_WEBHOOK_SECRET=your-webhook-signing-secret
```

Optional webhook configuration:

```env
LETTERMINT_WEBHOOK_PREFIX=lettermint
LETTERMINT_WEBHOOK_TOLERANCE=300
```

The webhook endpoint will be available at: `POST /{prefix}/webhook` (default: `/lettermint/webhook`)

### Listening to webhook events

```php
use Lettermint\Laravel\Events\MessageDelivered;
use Lettermint\Laravel\Events\MessageHardBounced;

// In EventServiceProvider
protected $listen = [
    MessageDelivered::class => [
        HandleEmailDelivered::class,
    ],
    MessageHardBounced::class => [
        HandleEmailBounced::class,
    ],
];
```

## Changes from official package

- Embedded `lettermint/lettermint-php` SDK directly (no external PHP 8.2+ dependency)
- Converted PHP 8.1 `enum` to class-based implementation
- Removed PHP 8.2 `readonly class` declarations
- Removed PHP 8.1 `readonly` property modifiers
- Lowered PHP requirement from `^8.2` to `^8.0`

## Full Documentation

For complete documentation on all features (idempotency, tags, metadata, etc.), see the official package:
https://github.com/lettermint/lettermint-laravel

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
