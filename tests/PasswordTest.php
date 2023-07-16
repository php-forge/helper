<?php

declare(strict_types=1);

namespace PHPForge\Helpers\Tests;

use PHPForge\Helpers\Password;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testGenerate(): void
    {
        $length = 10;
        $password = Password::generate($length);

        $this->assertSame($length, strlen($password));
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);

        $length = 20;
        $password = Password::generate($length);

        $this->assertSame($length, strlen($password));
    }
}
