<?php

declare(strict_types=1);

namespace PHPForge\Helper\Exception;

use function sprintf;

/**
 * Represents error message templates for attribute exceptions.
 *
 * Use {@see Message::getMessage()} to format the template with `sprintf()` arguments.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
enum Message: string
{
    /**
     * Error message for when the password length is too short.
     *
     * Format: "Password length must be at least '%d' characters."
     */
    case PASSWORD_LENGTH_TOO_SHORT = "Password length must be at least '%d' characters.";

    /**
     * Returns the formatted message string for the error case.
     *
     * Usage example:
     * ```php
     * throw new InvalidArgumentException(
     *     \PHPForge\Helper\Exception\Message::PASSWORD_LENGTH_TOO_SHORT->getMessage(),
     * );
     * ```
     *
     * @param int|string ...$argument Values to insert into the message template.
     *
     * @return string Formatted error message with interpolated arguments.
     */
    public function getMessage(int|string ...$argument): string
    {
        return sprintf($this->value, ...$argument);
    }
}
