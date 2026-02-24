<!-- markdownlint-disable MD041 -->
<p align="center">
    <a href="https://github.com/php-forge/helper" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/103309199?s=400&u=ca3561c692f53ed7eb290d3bb226a2828741606f&v=4" alt="PHP Forge" width="150px">
    </a>
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
    <em>Convert word casing, generate passwords, and list time zones with predictable output.</em>
</p>

## Features

<picture>
    <source media="(min-width: 768px)" srcset="./docs/svgs/features.svg">
    <img src="./docs/svgs/features-mobile.svg" alt="Feature Overview" style="width: 100%;">
</picture>

### Installation

```bash
composer require php-forge/helper:^0.1
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
// e.g. aB3#kL9!mN2@
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

## Documentation

For detailed setup, contribution flow, and test execution.

- 🧪 [Testing Guide](docs/testing.md)
- 🛠️ [Development Guide](docs/development.md)

## Package information

[![PHP](https://img.shields.io/badge/%3E%3D8.1-777BB4.svg?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/releases/8.1/en.php)
[![Latest Stable Version](https://img.shields.io/packagist/v/php-forge/helper.svg?style=for-the-badge&logo=packagist&logoColor=white&label=Stable)](https://packagist.org/packages/php-forge/helper)
[![Total Downloads](https://img.shields.io/packagist/dt/php-forge/helper.svg?style=for-the-badge&logo=composer&logoColor=white&label=Downloads)](https://packagist.org/packages/php-forge/helper)

## Quality code

[![Codecov](https://img.shields.io/codecov/c/github/php-forge/helper.svg?style=for-the-badge&logo=codecov&logoColor=white&label=Coverage)](https://codecov.io/github/php-forge/helper)
[![PHPStan Level Max](https://img.shields.io/badge/PHPStan-Level%20Max-4F5D95.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.com/php-forge/helper/actions/workflows/static.yml)
[![StyleCI](https://img.shields.io/badge/StyleCI-Passed-44CC11.svg?style=for-the-badge&logo=github&logoColor=white)](https://github.styleci.io/repos/667051036?branch=main)

## Our social networks

[![Follow on X](https://img.shields.io/badge/-Follow%20on%20X-1DA1F2.svg?style=for-the-badge&logo=x&logoColor=white&labelColor=000000)](https://x.com/Terabytesoftw)

## License

[![License](https://img.shields.io/badge/License-BSD--3--Clause-brightgreen.svg?style=for-the-badge&logo=opensourceinitiative&logoColor=white&labelColor=555555)](LICENSE)
