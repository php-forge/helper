<?php

declare(strict_types=1);

namespace PHPForge\Helpers;

use function array_map;
use function implode;
use function random_int;
use function strlen;

/**
 * Provides a method to generate user-friendly random passwords containing at least one lowercase letter, one uppercase
 * letter, and one digit. The remaining characters in the password are chosen at random from a set of special
 * characters, making it suitable for creating secure yet user-friendly passwords.
 */
final class Password
{
    /**
     * Generate password.
     *
     * Generates user-friendly random password containing at least one lower case letter, one uppercase letter and one
     * digit. The remaining characters in the password are chosen at random from those three sets
     *
     * @param int $length
     *
     * @return string
     */
    public static function generate(int $length): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?';
        $chars_length = strlen($chars);
        $password = '';

        $password = implode(
            '',
            array_map(
                static fn (int $i) => $chars[random_int($i, $chars_length - $i)],
                range(1, $length),
            ),
        );

        return $password;
    }
}
