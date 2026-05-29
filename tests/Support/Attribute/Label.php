<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Attribute;

use Attribute;

/**
 * Stub repeatable attribute used for reflection attribute tests.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final readonly class Label
{
    public function __construct(public string $value) {}
}
