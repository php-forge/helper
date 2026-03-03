<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Model;

use PHPForge\Helper\Tests\Support\Attribute\Label;
use PHPForge\Helper\Tests\Support\Attribute\Marker;
use PHPForge\Helper\Tests\Support\Contract\BothContract;
use PHPForge\Helper\Tests\Support\Contract\LeftContract;
use PHPForge\Helper\Tests\Support\Contract\RightContract;

/**
 * Stub model exposing varied property metadata for reflection helper tests.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
#[Label('model')]
final class ReflectionFixture
{
    public int $id = 1;

    public LeftContract&RightContract $intersection;

    #[Label('primary')]
    #[Label('secondary')]
    #[Marker]
    public string $name = '';

    public string|null $nullable = null;

    public mixed $payload = null;

    public static string $static = 'static';

    public int|string $union = 1;

    /**
     * @var mixed
     */
    public $untyped;

    private string $hidden = 'hidden';

    public function __construct()
    {
        $this->intersection = new BothContract();
    }

    public function hidden(): string
    {
        return $this->hidden;
    }
}
