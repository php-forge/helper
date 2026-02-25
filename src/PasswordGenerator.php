<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use InvalidArgumentException;
use PHPForge\Helper\Exception\Message;

use function count;
use function strlen;

/**
 * Generates secure passwords from mixed character sets.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class PasswordGenerator
{
    /**
     * Digits for password generation.
     */
    private const DIGITS = '0123456789';

    /**
     * Lowercase letters for password generation.
     */
    private const LOWERCASE = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * Character pools for password generation.
     */
    private const POOL = [
        self::LOWERCASE,
        self::UPPERCASE,
        self::DIGITS,
        self::SPECIAL,
    ];

    /**
     * Special characters for password generation.
     */
    private const SPECIAL = '!@#$%^&*()_-=+;:,.?';

    /**
     * Uppercase letters for password generation.
     */
    private const UPPERCASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Generates a random password with required character diversity.
     *
     * Guarantees at least one lowercase letter, one uppercase letter, one digit, and one special character.
     * Uses all character groups as the random pool for remaining characters.
     *
     * Usage example:
     * ```php
     * $password = \PHPForge\Helper\PasswordGenerator::generate(12);
     * ```
     *
     * @param int $length Length of the password to generate.
     *
     * @throws InvalidArgumentException When '$length' is less than '4'.
     *
     * @return string Generated password.
     */
    public static function generate(int $length): string
    {
        if ($length < 4) {
            throw new InvalidArgumentException(
                Message::PASSWORD_LENGTH_TOO_SHORT->getMessage(4),
            );
        }

        $requiredCharacters = [
            self::randomCharacterFrom(self::LOWERCASE),
            self::randomCharacterFrom(self::UPPERCASE),
            self::randomCharacterFrom(self::DIGITS),
            self::randomCharacterFrom(self::SPECIAL),
        ];

        $randomCharacters = [];
        $remainingLength = $length - 4;

        $fullPool = implode('', self::POOL);

        for ($index = 0; $index < $remainingLength; $index++) {
            $randomCharacters[] = self::randomCharacterFrom($fullPool);
        }

        $passwordCharacters = [...$requiredCharacters, ...$randomCharacters];

        return self::shuffleCharacters($passwordCharacters);
    }

    /**
     * Returns one random character from a given pool.
     *
     * @param non-empty-string $pool Allowed characters.
     *
     * @return string One random character.
     */
    private static function randomCharacterFrom(string $pool): string
    {
        return $pool[random_int(0, strlen($pool) - 1)];
    }

    /**
     * Shuffles password characters using a cryptographically secure algorithm.
     *
     * @param list<string> $characters Characters to shuffle.
     */
    private static function shuffleCharacters(array $characters): string
    {
        $shuffled = '';
        $remaining = count($characters);

        for (; $remaining > 0; --$remaining) {
            $index = random_int(0, $remaining - 1);
            $removedCharacters = array_splice($characters, $index, 1);

            $shuffled .= $removedCharacters[0] ?? '';
        }

        return $shuffled;
    }
}
