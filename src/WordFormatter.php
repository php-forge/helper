<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use function explode;
use function implode;
use function preg_match;
use function preg_replace;
use function preg_split;
use function str_contains;
use function strtolower;
use function ucfirst;

/**
 * Provides methods to manipulate and format words within a text string, including capitalization, case conversion,
 * and other word-related operations.
 */
final class WordFormatter
{
    /**
     * Converts a string to words with capitalized first letters.
     *
     * This function takes a string as input and converts it into words with the first letter of each word capitalized.
     * The input string can be in different formats, such as camelCase or snake_case, and the function will handle them
     * properly.
     * If the input string is in uppercase, it will be treated as a single word and capitalized accordingly.
     *
     * @param string $value The input string to be converted.
     *
     * @return string The string with words having capitalized first letters separated by spaces.
     */
    public static function capitalizeToWords(string $value): string
    {
        if (preg_match('/^[A-Z][^_]*(_[A-Z][^_]*)*/', $value)) {
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
        $words = preg_split('/(?=[A-Z])|_/', $value);

        foreach ($words as $word) {
            $capitalizedWords[] = ucfirst($word);
        }

        return implode(' ', $capitalizedWords);
    }

    /**
     * Converts a camelCase formatted string to snake_case.
     *
     * @param string $value The camelCase formatted string to convert.
     */
    public static function camelCaseToSnakeCase(string $value): string
    {
        $snakeCase = preg_replace('/([A-Z])/', '_$1', $value);
        $snakeCase = ltrim($snakeCase, '_'); // Eliminar guión bajo inicial si está presente
        return strtolower($snakeCase);
    }

    /**
     * Convert a snake_case formatted string to camelCase.
     *
     * @param string $snakeCaseString The snake_case formatted string to convert.
     *
     * @return string The converted camelCase string.
     */
    public static function snakeCaseToCamelCase(string $snakeCaseString): string
    {
        if (str_contains($snakeCaseString, '_') === false) {
            return $snakeCaseString;
        }

        $words = explode('_', $snakeCaseString);
        $camelCase = '';

        foreach ($words as $index => $word) {
            if ($index === 0) {
                $camelCase = $word;
            } else {
                $camelCase .= ucfirst($word);
            }
        }

        return $camelCase;
    }
}
