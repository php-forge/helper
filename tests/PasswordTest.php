<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use PHPForge\Helper\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testGenerate(): void
    {
        $length = 10;
        $password = Password::generate($length);

        $this->assertSame($length, strlen($password));

        $length = 20;
        $password = Password::generate($length);

        $this->assertSame($length, strlen($password));
    }
}
