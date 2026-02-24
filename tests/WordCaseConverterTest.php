<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use PHPForge\Helper\Tests\Provider\WordCaseConverterProvider;
use PHPForge\Helper\WordCaseConverter;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use PHPUnit\Framework\TestCase;
use Xepozz\InternalMocker\MockerState;

/**
 * Unit tests for the {@see WordCaseConverter} helper.
 *
 * Test coverage.
 * - Ensures `camelToSnake()` converts camel case values to snake case.
 * - Ensures `snakeToCamel()` returns early without calling `explode()` when no underscore exists.
 * - Ensures `snakeToCamel()` returns expected camel case values.
 * - Ensures `toTitleWords()` formats snake case, camel case, and uppercase values consistently.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class WordCaseConverterTest extends TestCase
{
    #[DataProviderExternal(WordCaseConverterProvider::class, 'camelToSnakeCases')]
    public function testCamelToSnake(string $input, string $expected, string $message): void
    {
        self::assertSame(
            $expected,
            WordCaseConverter::camelToSnake($input),
            $message,
        );
    }

    #[DataProviderExternal(WordCaseConverterProvider::class, 'snakeToCamelCases')]
    public function testSnakeToCamel(string $input, string $expected, string $message): void
    {
        self::assertSame(
            $expected,
            WordCaseConverter::snakeToCamel($input),
            $message,
        );
    }

    public function testSnakeToCamelReturnsEarlyWithoutExplodeWhenNoUnderscore(): void
    {
        MockerState::addCondition('PHPForge\\Helper', 'str_contains', ['plainword', '_'], false);

        self::assertSame(
            'plainword',
            WordCaseConverter::snakeToCamel('plainword'),
            'Should return input unchanged when no underscore exists.',
        );
        self::assertCount(
            1,
            MockerState::getTraces('PHPForge\\Helper', 'str_contains'),
            'Should evaluate underscore presence exactly once.',
        );
        self::assertCount(
            0,
            MockerState::getTraces('PHPForge\\Helper', 'explode'),
            "Should not call 'explode()' without underscores.",
        );
    }

    #[DataProviderExternal(WordCaseConverterProvider::class, 'titleWordsCases')]
    public function testToTitleWords(string $input, string $expected, string $message): void
    {
        self::assertSame(
            $expected,
            WordCaseConverter::toTitleWords($input),
            $message,
        );
    }
}
