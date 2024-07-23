# Filament Unlayer

![image](https://github.com/user-attachments/assets/92204605-3edf-48ba-81a8-0eadce20b2c5)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/InfinityXTech/filament-unlayer.svg?style=flat-square)](https://packagist.org/packages/InfinityXTech/filament-unlayer)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/InfinityXTech/filament-unlayer/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/InfinityXTech/filament-unlayer/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/InfinityXTech/filament-unlayer.svg?style=flat-square)](https://packagist.org/packages/InfinityXTech/filament-unlayer)


This is a filament wrapper for unlayer editor with custom select field with unlayer templates.


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
    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set)
        => $set('description', InfinityXTech\FilamentUnlayer\Services\GetTemplates::find($state))
    ),
Unlayer::make('description')->required()
```

You can still chain other methods on these since:

`SelectTemplate` is extending filament `Select` field.

`Unlayer` is extending filament `Field` class.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
