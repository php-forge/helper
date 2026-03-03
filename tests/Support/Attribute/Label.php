<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
final class Label
{
    public function __construct(public readonly string $value) {}
}
