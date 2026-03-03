# Usage examples

This document provides practical examples for word conversion, password generation, time zones, and reflection metadata.

## Convert camelCase to snake_case

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::camelToSnake('dateBirth');
// date_birth
```

## Convert snake_case to camelCase

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::snakeToCamel('date_birth');
// dateBirth
```

## Convert text to title words

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\WordCaseConverter;

$word = WordCaseConverter::toTitleWords('dateOfMessage');
// Date Of Message
```

## Generate passwords

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\PasswordGenerator;

$password = PasswordGenerator::generate(12);
// e.g. aB3#kL9!mN2@
```

## Retrieve all time zones

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\TimeZoneList;

$timezones = TimeZoneList::all();
// [['timezone' => 'Pacific/Midway', 'name' => 'Pacific/Midway (UTC -11:00)', 'offset' => -39600], ...]
```

## Inspect class metadata with Reflector

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\Reflector;

$shortName = Reflector::shortName(App\Domain\User::class);
$hasEmail = Reflector::hasProperty(App\Domain\User::class, 'email');
$typeNames = Reflector::propertyTypeNames(App\Domain\User::class, 'email');
$attributes = Reflector::propertyAttributes(App\Domain\User::class, 'email');
```

## Reflector cache lifecycle in long-running workers

```php
<?php

declare(strict_types=1);

namespace App;

use PHPForge\Helper\Reflector;

$size = Reflector::cacheSize();

if ($size > 400) {
    Reflector::clearCache();
}
```

## Next steps

- 📚 [Installation guide](installation.md)
- 🧪 [Testing guide](testing.md)
- 🛠️ [Development guide](development.md)
