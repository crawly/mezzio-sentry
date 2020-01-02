MezzioSentry
============

[![Latest Stable Version](https://poser.pugx.org/crawly/mezzio-sentry/v/stable)](https://packagist.org/packages/crawly/mezzio-sentry)
[![Total Downloads](https://poser.pugx.org/crawly/mezzio-sentry/downloads)](https://packagist.org/packages/crawly/mezzio-sentry)
[![License](https://poser.pugx.org/crawly/mezzio-sentry/license)](https://packagist.org/packages/crawly/mezzio-sentry)

Mezzio integration for Sentry (http://getsentry.com)

## Dependencies

* PHP 7.3+

## Installation

Installation of MezzioSentry is only officially supported using Composer:

```sh
php composer.phar require 'crawly/mezzio-sentry'
```

## Usage

### Library configuration

If the module was not automatically registered by composer, you need to enable the module by adding it to the list of registered modules in the config/config.php file of your project.

```php
// config/config.php

$aggregator = new ConfigAggregator([

    // MezzioSentry configuration
    \MezzioSentry\ConfigProvider::class,
  
    // ...
    
], $cacheConfig['config_cache_path']);
```

### Options

Here are the all options available

| Option name               | Default                      | Description                                                                                      |
|---------------------------|------------------------------|--------------------------------------------------------------------------------------------------|
| dsn                       | ``@$_SERVER['sentry_dsn']``  | Get Sentry DSN from a environment variable                         |
| development-environment   | false                        | Enable or disable in development environment                      |

#### Configuration file example

```php
// config/autoload/sentry.global.php

<?php

return [
    'sentry' => [
        'dsn' => 'https://my-dsn@sentry.io',
        'development-environment' => true,
    ],
];

```