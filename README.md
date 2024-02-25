<p align="center">
    <a href="https://github.com/php-forge/helpers" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/103309199?s%25253D400%252526u%25253Dca3561c692f53ed7eb290d3bb226a2828741606f%252526v%25253D4" height="100px">
    </a>
    <h1 align="center">Collection of Helper for PHP.</h1>
    <br>
</p>

<p align="center">
    <a href="https://github.com/php-forge/helpers/actions/workflows/build.yml" target="_blank">
        <img src="https://github.com/php-forge/helpers/actions/workflows/build.yml/badge.svg" alt="PHPUnit">
    </a>
    <a href="https://codecov.io/gh/php-forge/helpers" target="_blank">
        <img src="https://codecov.io/gh/php-forge/helpers/branch/main/graph/badge.svg?token=MF0XUGVLYC" alt="Codecov">
    </a>
    <a href="https://dashboard.stryker-mutator.io/reports/github.com/php-forge/helpers/main" target="_blank">
        <img src="https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fphp-forge%2Fhelpers%2Fmain" alt="Infection">
    </a>
    <a href="https://github.com/php-forge/helpers/actions/workflows/static.yml" target="_blank">
        <img src="https://github.com/php-forge/helpers/actions/workflows/static.yml/badge.svg" alt="Psalm">
    </a>
    <a href="https://shepherd.dev/github/php-forge/helpers" target="_blank">
        <img src="https://shepherd.dev/github/php-forge/helpers/coverage.svg" alt="Psalm Coverage">
    </a>
    <a href="https://github.styleci.io/repos/667051036?branch=main">
        <img src="https://github.styleci.io/repos/667051036/shield?branch=main" alt="StyleCI">
    </a>
</p>

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```shell
composer require --prefer-dist php-forge/helpers:"^0.1"
```

or add

```json
"php-forge/helpers": "^0.1"
```

## Usage

The repository contains a collection of utility functions designed to simplify common programming tasks in PHP.

Whether you're working on web development, data processing, or other projects, these helper functions can save you time
and effort.

## Converts a camelCase formatted string to snake_case

```php
<?php

declare(strict_types=1);

use PHPForge\Helper\WordFormatter;

$word = WordFormatter::camelCaseToSnakeCase('date_birth');
```

## Convert a snake_case formatted string to camelCase

```php
<?php

declare(strict_types=1);

use PHPForge\Helper\WordFormatter;

$word = WordFormatter::snakeCaseToCamelCase('date_birth');
```

##  Converts a string to words with capitalized first letters

```php
<?php

declare(strict_types=1);

use PHPForge\Helper\WordFormatter;

$word = WordFormatter::capitalizeToWords('Date Birth');
```

## Generate ramdon pasword

```php
<?php

declare(strict_types=1);

use PHPForge\Helper\Password;

$password = Password::generate(8);
```


## Get all timezones

```php
<?php

declare(strict_types=1);

use PHPForge\Helper\Timezone;

$timezones = Timezone::getAll();
```

## Testing

[Check the documentation testing](/docs/testing.md) to learn about testing.

## Support versions

[![PHP81](https://img.shields.io/badge/PHP-%3E%3D8.1-787CB5)](https://www.php.net/releases/8.1/en.php)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Our social networks

[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/Terabytesoftw)
