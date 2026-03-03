<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Marker {}
