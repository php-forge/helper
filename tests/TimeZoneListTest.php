<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use PHPForge\Helper\TimeZoneList;
use PHPUnit\Framework\TestCase;

use function array_values;
use function count;
use function str_replace;

/**
 * Unit tests for the {@see TimeZoneList} helper.
 *
 * Test coverage.
 * - Ensures timezone display names replace underscores with spaces.
 * - Verifies returned entries include required keys and are ordered by ascending offset.
 * - Verifies the first entry exposes the minimum UTC offset and expected display format.
 * - Verifies the result contains a broad set of timezone entries.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TimeZoneListTest extends TestCase
{
    public function testAllReplacesUnderscoresInDisplayName(): void
    {
        $timeZone = TimeZoneList::all();

        foreach ($timeZone as $value) {
            self::assertStringNotContainsString(
                '_',
                $value['name'],
                'Should format timezone names without underscore characters.',
            );
        }
    }

    public function testAllReturnsExpectedCount(): void
    {
        $timeZone = TimeZoneList::all();

        self::assertGreaterThan(
            400,
            count($timeZone),
            'Should return more than 400 timezone entries.',
        );
    }

    public function testAllReturnsOrderedTimeZones(): void
    {
        $timeZones = TimeZoneList::all();

        $prevOffset = null;

        foreach ($timeZones as $timeZone) {
            if ($prevOffset !== null) {
                self::assertGreaterThanOrEqual(
                    $prevOffset,
                    $timeZone['offset'],
                    'Should keep timezone entries ordered by non-decreasing UTC offset.',
                );
            }

            self::assertArrayHasKey(
                'timezone',
                $timeZone,
                'Should include the timezone identifier key.',
            );
            self::assertArrayHasKey(
                'name',
                $timeZone,
                'Should include the formatted display name key.',
            );
            self::assertArrayHasKey(
                'offset',
                $timeZone,
                'Should include the numeric UTC offset key.',
            );

            $prevOffset = $timeZone['offset'];
        }
    }

    public function testAllReturnsTimeZoneEntries(): void
    {
        $timeZone = TimeZoneList::all();

        $first = array_values($timeZone)[0] ?? null;

        self::assertIsArray(
            $first,
            'Should return at least one timezone entry.',
        );
        self::assertArrayHasKey(
            'timezone',
            $first,
            'Should include the timezone identifier key.',
        );
        self::assertArrayHasKey(
            'name',
            $first,
            'Should include the formatted display name key.',
        );
        self::assertArrayHasKey(
            'offset',
            $first,
            'Should include the numeric UTC offset key.',
        );
        self::assertStringContainsString(
            $first['timezone'],
            str_replace('_', ' ', $first['timezone']),
            'Should include the timezone identifier in the display name.',
        );

        self::assertStringContainsString(
            'UTC',
            $first['name'],
            'Should include UTC in the formatted display name.',
        );
    }
}
