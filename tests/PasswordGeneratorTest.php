<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use InvalidArgumentException;
use PHPForge\Helper\Exception\Message;
use PHPForge\Helper\PasswordGenerator;
use PHPUnit\Framework\TestCase;
use Xepozz\InternalMocker\MockerState;

use function array_slice;
use function preg_match;
use function preg_match_all;
use function strlen;

/**
 * Unit tests for the {@see PasswordGenerator} helper.
 *
 * Test coverage.
 * - Ensures generated passwords include lowercase, uppercase, digit, and special characters at minimum length.
 * - Ensures generated passwords preserve the requested length across repeated calls.
 * - Ensures generated passwords use the expected pool ordering and shuffle random bounds.
 * - Ensures password generation samples all character groups across larger generated buffers.
 * - Ensures shuffle logic removes one character per `array_splice()` call.
 * - Throws an exception when the requested password length is lower than the allowed minimum.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class PasswordGeneratorTest extends TestCase
{
    /**
     * @return array<string, array{int, string}>
     */
    public static function poolIndexesProvider(): array
    {
        return [
            'lowercase segment starts at zero' => [0, 'a'],
            'special segment starts at sixty two' => [62, '!'],
            'uppercase segment starts at twenty six' => [26, 'A'],
        ];
    }

    public function testGenerateAllowsMinimalLengthForGuarantee(): void
    {
        $buffer = '';

        for ($i = 0; $i < 10; $i++) {
            $buffer .= PasswordGenerator::generate(50);
        }

        self::assertGreaterThan(
            20,
            preg_match_all('/[a-z]/', $buffer),
            'Should sample lowercase characters repeatedly.',
        );
        self::assertGreaterThan(
            20,
            preg_match_all('/[A-Z]/', $buffer),
            'Should sample uppercase characters repeatedly.',
        );
        self::assertGreaterThan(
            20,
            preg_match_all('/\d/', $buffer),
            'Should sample digit characters repeatedly.',
        );
        self::assertGreaterThan(
            20,
            preg_match_all('/[!@#$%^&*()_\-=+;:,.?]/', $buffer),
            'Should sample special characters repeatedly.',
        );
    }

    public function testGenerateCharacterDistributionIncludesAllCharacterGroups(): void
    {
        $buffer = '';

        for ($i = 0; $i < 10; $i++) {
            $buffer .= PasswordGenerator::generate(50);
        }

        self::assertGreaterThan(
            20,
            preg_match_all('/[a-z]/', $buffer),
            'Should sample lowercase characters repeatedly.',
        );
        self::assertGreaterThan(
            20,
            preg_match_all('/[A-Z]/', $buffer),
            'Should sample uppercase characters repeatedly.',
        );
        self::assertGreaterThan(
            20,
            preg_match_all('/\d/', $buffer),
            'Should sample digit characters repeatedly.',
        );
    }

    public function testGenerateProducesCorrectLengthAcrossMultipleInvocations(): void
    {
        for ($i = 0; $i < 20; $i++) {
            self::assertSame(
                12,
                strlen(PasswordGenerator::generate(12)),
                "Should preserve the requested password length of '12' characters.",
            );
        }
    }

    public function testGenerateReturnsExpectedLengthAndCharacterTypes(): void
    {
        $password = PasswordGenerator::generate(12);

        self::assertSame(
            12,
            strlen($password),
            "Should generate a password with the requested length of '12' characters.",
        );
        self::assertSame(
            1,
            preg_match('/[a-z]/', $password),
            "Should include at least '1' lowercase character.",
        );
        self::assertSame(
            1,
            preg_match('/[A-Z]/', $password),
            "Should include at least '1' uppercase character.",
        );
        self::assertSame(
            1,
            preg_match('/\d/', $password),
            "Should include at least '1' digit character.",
        );
        self::assertSame(
            1,
            preg_match('/[!@#$%^&*()_\-=+;:,.?]/', $password),
            "Should include at least '1' special character.",
        );
        self::assertSame(
            1,
            preg_match('/^[a-zA-Z0-9!@#$%^&*()_\-=+;:,.?]+$/', $password),
            'Should contain only characters from the configured password pool.',
        );
    }

    /**
     * Verifies the shuffle uses {@see \array_splice()} correctly (one item removed per iteration).
     *
     * - This test is intentionally coupled to the Fisher-Yates implementation.
     * - If you refactor the shuffle algorithm, update this test accordingly.
     */
    public function testGenerateUsesArraySpliceWithSingleItemRemoval(): void
    {
        PasswordGenerator::generate(4);

        /** @phpstan-var array<int, array{arguments: array{array<int, string>, int, int}}> $traces */
        $traces = MockerState::getTraces('PHPForge\\Helper', 'array_splice');

        self::assertCount(
            4,
            $traces,
            "Should invoke 'array_splice()' once per generated character at minimum length.",
        );

        foreach ($traces as $trace) {
            self::assertSame(
                1,
                $trace['arguments'][2],
                "Should remove exactly '1' character per splice operation.",
            );
        }
    }

    /**
     * Verifies character pool construction follows the expected order: lowercase, uppercase, digits, special.
     *
     * - This test verifies pool ordering internals.
     * - Refactoring the poolconstruction will require updating the expected character positions.
     *
     * @dataProvider poolIndexesProvider
     */
    public function testGenerateUsesExpectedCharacterPoolOrder(int $poolIndex, string $expectedPoolCharacter): void
    {
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 80], $poolIndex);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 25], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 9], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 18], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 4], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 3], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 2], 0);
        MockerState::addCondition('PHPForge\\Helper', 'random_int', [0, 1], 0);

        $password = PasswordGenerator::generate(5);

        self::assertSame(
            "aA0!{$expectedPoolCharacter}",
            $password,
            'Should append the expected pooled character after required character groups.',
        );
    }

    /**
     * Verifies shuffle uses decreasing random bounds per Fisher-Yates algorithm.
     *
     * - This test verifies Fisher-Yates bounds correctness.
     * - Any change to the shuffle implementation must preserve these bounds for cryptographic security.
     */
    public function testGenerateUsesExpectedShuffleRandomBounds(): void
    {
        PasswordGenerator::generate(4);

        $traces = MockerState::getTraces('PHPForge\\Helper', 'random_int');
        $shuffleTraces = array_slice($traces, 4);

        self::assertCount(
            4,
            $shuffleTraces,
            'Should run shuffle randomization once per output character.',
        );

        /** @var array<int, array{arguments: array{0: int, 1: int}}> $shuffleTraces */
        $bounds = [];

        foreach ($shuffleTraces as $trace) {
            $bounds[] = [$trace['arguments'][0], $trace['arguments'][1]];
        }

        self::assertSame(
            [[0, 3], [0, 2], [0, 1], [0, 0]],
            $bounds,
            'Should request decreasing random bounds while shuffling characters.',
        );
    }

    public function testThrowInvalidArgumentExceptionWhenLengthIsTooShort(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(Message::PASSWORD_LENGTH_TOO_SHORT->getMessage(4));

        PasswordGenerator::generate(3);
    }
}
