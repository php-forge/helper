<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests\Provider;

/**
 * Provides datasets for {@see \PHPForge\Helper\Tests\WordCaseConverterTest}.
 *
 * Provides representative input/output pairs for word case conversions.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class WordCaseConverterProvider
{
    /**
     * @return array<string, array{string, string, string}>
     */
    public static function camelToSnakeCases(): array
    {
        return [
            'created at splits' => [
                'createdAt',
                'created_at',
                'Should separate trailing camel case transitions.',
            ],
            'date birth splits once' => [
                'dateBirth',
                'date_birth',
                'Should separate single internal transitions.',
            ],
            'date of message splits multiple' => [
                'dateOfMessage',
                'date_of_message',
                'Should separate multiple internal transitions.',
            ],
            'leading uppercase normalizes' => [
                'Foo',
                'foo',
                'Should normalize leading uppercase letters.',
            ],
            'lowercase remains unchanged' => [
                'foo',
                'foo',
                'Should keep lowercase words unchanged.',
            ],
            'pascal case normalizes' => [
                'FooBar',
                'foo_bar',
                'Should normalize Pascal case to snake case.',
            ],
            'single transition splits' => [
                'fooBar',
                'foo_bar',
                'Should separate camel case transitions.',
            ],
            'single word created remains unchanged' => [
                'created',
                'created',
                'Should keep single lowercase words unchanged.',
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function snakeToCamelCases(): array
    {
        return [
            'capitalized first segment is normalized to lower camel' => [
                'Date_birth',
                'dateBirth',
                'Should normalize the first segment to lowercase for camel case output.',
            ],
            'created at camelizes' => [
                'created_at',
                'createdAt',
                'Should camelize one trailing word boundary.',
            ],
            'date birth camelizes' => [
                'date_birth',
                'dateBirth',
                'Should camelize two-word snake case values.',
            ],
            'date of birth camelizes' => [
                'date_of_birth',
                'dateOfBirth',
                'Should camelize multi-word snake case values.',
            ],
            'lowercase remains unchanged' => [
                'foo',
                'foo',
                'Should keep lowercase words unchanged.',
            ],
            'one underscore boundary camelizes' => [
                'foo_bar',
                'fooBar',
                'Should camelize one underscore boundary.',
            ],
            'single word created remains unchanged' => [
                'created',
                'created',
                'Should keep single lowercase words unchanged.',
            ],
        ];
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function titleWordsCases(): array
    {
        return [
            'camel case multiple transitions' => [
                'dateOfMessage',
                'Date Of Message',
                'Should split multi-transition camel case into title words.',
            ],
            'camel case one transition' => [
                'dateBirth',
                'Date Birth',
                'Should split camel case into title words.',
            ],
            'each segment properly capitalized' => [
                'Test_Case',
                'Test Case',
                'Should capitalize each segment separated by underscores.',
            ],
            'mixed case with underscore' => [
                'FooBar_baz',
                'Foo Bar Baz',
                'Should handle mixed case with underscores correctly.',
            ],
            'mixed case with uppercase and lowercase' => [
                'ABC_def',
                'ABC Def',
                'Should handle mixed case with multiple underscores correctly.',
            ],
            'plain text mixed case' => [
                'Foo Bar',
                'Foo bar',
                'Should normalize mixed-case plain text words.',
            ],
            'plain text with space' => [
                'foo bar',
                'Foo bar',
                'Should preserve existing spaces in plain text.',
            ],
            'single capitalized word' => [
                'Foo',
                'Foo',
                'Should preserve a capitalized single word.',
            ],
            'single created lowercase' => [
                'created',
                'Created',
                'Should capitalize lowercase uppercase-insensitive words.',
            ],
            'single created uppercase' => [
                'CREATED',
                'Created',
                'Should normalize all-uppercase single words.',
            ],
            'single lowercase word' => [
                'foo',
                'Foo',
                'Should capitalize a lowercase single word.',
            ],
            'snake case lowercase' => [
                'created_at',
                'Created At',
                'Should convert snake case to title words.',
            ],
            'snake case uppercase' => [
                'CREATED_AT',
                'Created At',
                'Should normalize uppercase snake case to title words.',
            ],
        ];
    }
}
