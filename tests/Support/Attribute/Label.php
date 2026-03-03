<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Attribute;

use Attribute;

/**
 * Stub repeatable attribute used for reflection attribute tests.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class Label
{
    public function __construct(public readonly string $value) {}
}
