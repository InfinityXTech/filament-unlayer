# Filament Unlayer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/InfinityXTech/filament-unlayer.svg?style=flat-square)](https://packagist.org/packages/InfinityXTech/filament-unlayer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/InfinityXTech/filament-unlayer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/InfinityXTech/filament-unlayer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/InfinityXTech/filament-unlayer/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/InfinityXTech/filament-unlayer/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/InfinityXTech/filament-unlayer.svg?style=flat-square)](https://packagist.org/packages/InfinityXTech/filament-unlayer)

<!--delete-->
---
This repo can be used to scaffold a Filament plugin. Follow these steps to get started:

1. Press the "Use this template" button at the top of this repo to create a new repo with the contents of this skeleton.
2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.
3. Make something great!
---
<!--/delete-->

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require InfinityXTech/filament-unlayer
```


You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-unlayer-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-unlayer-views"
```

## Usage

As any other filament form field:

```php
Unlayer::make('content')->required()
```

In case you want to select unlayer templates you can use:

```php
SelectTemplate::make('template'),
Unlayer::make('content')->required()
```

By default the Unlayer field name should `content` but if you need to change it you will need to update `SelectTemplate`:

```php
SelectTemplate::make('template')
    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $set('description', InfinityXTech\FilamentUnlayer\Services\GetTemplates::find($state))),
Unlayer::make('description')->required()
```

You can still chain other methods on these since:

`SelectTemplate` is extending filament `Select` field.
`Unlayer` is extending filament `Field` class.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [:author_name](https://github.com/:author_username)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
