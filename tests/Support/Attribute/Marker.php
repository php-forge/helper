<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Attribute;

use Attribute;

/**
 * Stub marker attribute used for filtered reflection attribute tests at class and property level.
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_PROPERTY)]
final class Marker {}
