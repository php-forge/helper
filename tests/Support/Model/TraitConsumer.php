<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Model;

use PHPForge\Helper\Tests\Support\Contract\UsesTimestamp;

/**
 * Stub class consuming a trait to keep trait fixtures analyzable in tests.
 */
final class TraitConsumer
{
    use UsesTimestamp;
}
