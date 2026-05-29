<!-- markdownlint-disable MD041 -->
<p align="center">
    <picture>
        <img src="https://raw.githubusercontent.com/php-forge/.github/refs/heads/main/logo/logo.png" alt="PHP Forge" width="25%">
    </picture>
    <h1 align="center">PHP Helper</h1>
    <br>
</p>
<!-- markdownlint-enable MD041 -->

<p align="center">
    <a href="https://github.com/php-forge/helper/actions/workflows/build.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/php-forge/helper/build.yml?style=for-the-badge&label=PHPUnit&logo=github" alt="PHPUnit">
    </a>
    <a href="https://dashboard.stryker-mutator.io/reports/github.com/php-forge/helper/main" target="_blank">
        <img src="https://img.shields.io/endpoint?style=for-the-badge&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fphp-forge%2Fhelper%2Fmain" alt="Mutation Testing">
    </a>
    <a href="https://github.com/php-forge/helper/actions/workflows/static.yml" target="_blank">
        <img src="https://img.shields.io/github/actions/workflow/status/php-forge/helper/static.yml?style=for-the-badge&label=PHPStan&logo=github" alt="PHPStan">
    </a>
</p>

<p align="center">
    <strong>Small, focused helpers for common PHP tasks</strong><br>
    <em>Convert word casing, inspect metadata, generate passwords, and list time zones with predictable output.</em>
</p>

## Features

<picture>
    <source media="(max-width: 767px)" srcset="./docs/svgs/features-mobile.svg">
    <img src="./docs/svgs/features.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require php-forge/helper:^0.3
```

### Quick start

#### Convert camelCase to snake_case

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::camelToSnake('dateBirth');
// date_birth
```

#### Convert snake_case to camelCase

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::snakeToCamel('date_birth');
// dateBirth
```

#### Convert text to title words

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::toTitleWords('dateOfMessage');
// Date Of Message
```

#### Generate passwords

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\PasswordGenerator;

$password = PasswordGenerator::generate(12);
// for example, aB3#kL9!mN2@
```

#### Retrieve all time zones

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\TimeZoneList;

$timezones = TimeZoneList::all();
// [['timezone' => 'Pacific/Midway', 'name' => 'Pacific/Midway (UTC -11:00)', 'offset' => -39600], ...]
```

#### Inspect class metadata with Reflector

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\Reflector;

$shortName = Reflector::shortName(\App\Domain\User::class);
$types = Reflector::propertyTypeNames(\App\Domain\User::class, 'email');
$attributes = Reflector::propertyAttributes(\App\Domain\User::class, 'email');
```

## Documentation

For detailed configuration options and advanced usage.

- 📚 [Installation Guide](docs/installation.md)
- 💡 [Usage Examples](docs/examples.md)
- 🧪 [Testing Guide](docs/testing.md)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.3-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.3/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/php-forge/helper.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/php-forge/helper)
[![Total Downloads](https://img.shields.io/packagist/dt/php-forge/helper.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/php-forge/helper)

## Quality code

[![Codecov](https://img.shields.io/codecov/c/github/php-forge/helper.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage)](https://codecov.io/github/php-forge/helper)
[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/php-forge/helper/actions/workflows/static.yml)
[![StyleCI](https://img.shields.io/badge/StyleCI-Passed-44CC11.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.styleci.io/repos/667051036?branch=main)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)
[![Follow on Facebook](https://img.shields.io/badge/-Follow%20on%20Facebook-1877F2.svg?style=for-the-badge&logo=facebook&logoColor=white&labelColor=000000)](https://www.facebook.com/wilmer.arambula.9)
[![Join our Subreddit](https://img.shields.io/badge/-Join%20our%20Subreddit-FF4500.svg?style=for-the-badge&logo=reddit&logoColor=white&labelColor=000000)](https://www.reddit.com/r/Yii2/)
[![Join on Telegram](https://img.shields.io/badge/-Join%20on%20Telegram-26A5E4.svg?style=for-the-badge&logo=telegram&logoColor=white&labelColor=000000)](https://t.me/yii_framework_in_english)
[![Join our LinkedIn](https://img.shields.io/badge/-Join%20our%20LinkedIn%20Group-0A66C2.svg?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2ZmZiI+PHBhdGggZD0iTTIwLjQ0NyAyMC40NTJoLTMuNTU0di01LjU2OWMwLTEuMzI4LS4wMjctMy4wMzctMS44NTItMy4wMzctMS44NTMgMC0yLjEzNiAxLjQ0NS0yLjEzNiAyLjkzOXY1LjY2N0g5LjM1MVY5aDMuNDE0djEuNTYxaC4wNDZjLjQ3Ny0uOSAxLjYzNy0xLjg1IDMuMzctMS44NSAzLjYwMSAwIDQuMjY3IDIuMzcgNC4yNjcgNS40NTV2Ni4yODZ6TTUuMzM3IDcuNDMzYy0xLjE0NCAwLTIuMDYzLS45MjYtMi4wNjMtMi4wNjUgMC0xLjEzOC45Mi0yLjA2MyAyLjA2My0yLjA2MyAxLjE0IDAgMi4wNjQuOTI1IDIuMDY0IDIuMDYzIDAgMS4xMzktLjkyNSAyLjA2NS0yLjA2NCAyLjA2NXptMS43ODIgMTMuMDE5SDMuNTU1VjloMy41NjR2MTEuNDUyek0yMi4yMjUgMEgxLjc3MUMuNzkyIDAgMCAuNzc0IDAgMS43Mjl2MjAuNTQyQzAgMjMuMjI3Ljc5MiAyNCAxLjc3MSAyNGgyMC40NTFDMjMuMiAyNCAyNCAyMy4yMjcgMjQgMjIuMjcxVjEuNzI5QzI0IC43NzQgMjMuMiAwIDIyLjIyNSAweiIvPjwvc3ZnPg==&labelColor=000000)](https://www.linkedin.com/groups/1483367/)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
