<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Support\Model;

use PHPForge\Helper\Tests\Support\Attribute\Label;
use PHPForge\Helper\Tests\Support\Attribute\Marker;
use PHPForge\Helper\Tests\Support\Contract\BothContract;
use PHPForge\Helper\Tests\Support\Contract\LeftContract;
use PHPForge\Helper\Tests\Support\Contract\RightContract;

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
