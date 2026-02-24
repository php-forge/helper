<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use DateTime;
use DateTimeZone;
use Exception;

use function array_column;
use function array_multisort;
use function str_replace;

/**
 * Provides timezone metadata sorted by UTC offset.
 *
 * @copyright Copyright (C) 2026 Terabytesoftw.
 * @license https://opensource.org/license/bsd-3-clause BSD 3-Clause License.
 */
final class TimeZoneList
{
    /**
     * Returns all available timezones with formatted names.
     *
     * Usage example:
     * ```php
     * $timeZones = \PHPForge\Helper\TimeZoneList::all();
     * ```
     *
     * @throws Exception When an error occurs while fetching time zone information.
     *
     * @return array Timezone entries sorted by offset.
     *
     * @phpstan-return array<int, array{timezone: string, name: string, offset: int}>
     */
    public static function all(): array
    {
        return self::sortByOffset(self::buildEntries(self::identifiers()));
    }

    /**
     * Builds timezone entries from identifiers.
     *
     * @param array $identifiers The timezone identifiers.
     *
     * @throws Exception When timezone metadata cannot be generated.
     *
     * @return array Built timezone entries.
     *
     * @phpstan-param list<string> $identifiers
     * @phpstan-return array<int, array{timezone: string, name: string, offset: int}>
     */
    private static function buildEntries(array $identifiers): array
    {
        $entries = [];

        foreach ($identifiers as $identifier) {
            if ($identifier !== '') {
                $entries[] = self::createEntry($identifier);
            }
        }

        return $entries;
    }

    /**
     * Creates a timezone entry for one identifier.
     *
     * @param string $identifier Timezone identifier.
     *
     * @throws Exception When timezone metadata cannot be generated.
     *
     * @return array Timezone entry.
     *
     * @phpstan-return array{timezone: string, name: string, offset: int}
     */
    private static function createEntry(string $identifier): array
    {
        $date = new DateTime('now', new DateTimeZone($identifier));
        $offset = $date->getOffset();

        return [
            'timezone' => $identifier,
            'name' => self::formatName($identifier, $date->format('P')),
            'offset' => $offset,
        ];
    }

    /**
     * Formats a timezone name with UTC offset.
     *
     * @param string $identifier Timezone identifier.
     * @param string $formattedOffset Offset in `+HH:MM` or `-HH:MM` format.
     *
     * @return string Formatted display name.
     */
    private static function formatName(string $identifier, string $formattedOffset): string
    {
        $name = str_replace('_', ' ', $identifier);

        return "$name (UTC $formattedOffset)";
    }

    /**
     * Returns all valid timezone identifiers.
     *
     * @return array Timezone identifiers.
     *
     * @phpstan-return list<string>
     */
    private static function identifiers(): array
    {
        return DateTimeZone::listIdentifiers();
    }

    /**
     * Sorts timezone entries by offset in ascending order.
     *
     * @param array $entries Timezone entries.
     *
     * @return array Sorted timezone entries.
     *
     * @phpstan-param array<int, array{timezone: string, name: string, offset: int}> $entries
     * @phpstan-return array<int, array{timezone: string, name: string, offset: int}>
     */
    private static function sortByOffset(array $entries): array
    {
        $offsets = array_column($entries, 'offset');
        array_multisort($offsets, SORT_ASC, $entries);

        return $entries;
    }
}
