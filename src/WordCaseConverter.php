<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use function implode;
use function ltrim;
use function preg_match;
use function preg_replace;
use function preg_split;
use function strtolower;
use function ucfirst;

/**
 * Converts words between title, camel, and snake casing.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class WordCaseConverter
{
    /**
     * Converts a camelCase string to snake_case.
     *
     * Usage example:
     * ```php
     * $snake = \PHPForge\Helper\WordCaseConverter::camelToSnake('dateOfMessage');
     * ```
     *
     * @param string $value CamelCase formatted string to convert.
     *
     * @return string SnakeCase representation.
     */
    public static function camelToSnake(string $value): string
    {
        $snakeCase = preg_replace('/([A-Z])/', '_$1', $value);
        $snakeCase = ltrim((string) $snakeCase, '_');

        return strtolower($snakeCase);
    }

    /**
     * Converts a snake_case string to camelCase.
     *
     * Usage example:
     * ```php
     * $camel = \PHPForge\Helper\WordCaseConverter::snakeToCamel('date_of_birth');
     * ```
     *
     * @param string $snakeCaseString SnakeCase formatted string to convert.
     *
     * @return string CamelCase representation.
     */
    public static function snakeToCamel(string $snakeCaseString): string
    {
        if (str_contains($snakeCaseString, '_') === false) {
            return $snakeCaseString;
        }

        $words = explode('_', $snakeCaseString);
        $camelCase = '';

        foreach ($words as $index => $word) {
            if ($index === 0) {
                $camelCase = strtolower($word);
            } else {
                $camelCase .= ucfirst($word);
            }
        }

        return $camelCase;
    }

    /**
     * Converts input text to title words.
     *
     * Splits snake_case and lower-to-upper camel transitions, then capitalizes each resulting segment.
     *
     * Usage example:
     * ```php
     * $words = \PHPForge\Helper\WordCaseConverter::toTitleWords('dateOfMessage');
     * ```
     *
     * @param string $value Input string to be converted.
     *
     * @return string String with words having capitalized first letters separated by spaces.
     */
    public static function toTitleWords(string $value): string
    {
        if (preg_match('/^[A-Z][^_]*(_[A-Z][^_]*)*$/', $value) === 1) {
            $strings = explode('_', $value);
            $word = '';

            foreach ($strings as $index => $string) {
                $word .= match ($index === 0) {
                    true => ucfirst(strtolower($string)),
                    default => ' ' . ucfirst(strtolower($string)),
                };
            }

            return $word;
        }

        $capitalizedWords = [];
        $words = preg_split('/(?<=[a-z])(?=[A-Z])|_/', $value);

        if ($words === false) {
            return ucfirst($value);
        }

        foreach ($words as $word) {
            $capitalizedWords[] = ucfirst($word);
        }

        return implode(' ', $capitalizedWords);
    }
}
