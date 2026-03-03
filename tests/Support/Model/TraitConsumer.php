<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Model;

use PHPForge\Helper\Tests\Support\Contract\UsesTimestamp;

/**
 * Stub class consuming a trait to keep trait fixtures analyzable in tests.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TraitConsumer
{
    use UsesTimestamp;
}
