<?php

declare(strict_types=1);

namespace PHPForge\Helper;

use DateTime;
use DateTimeZone;
use Exception;

use function array_column;
use function array_multisort;

/**
 * Provides methods to work with time zones.
 */
final class TimeZone
{
    /**
     * Get all time zones.
     *
     * This method retrieves information about all available time zones, including their names, offsets, and formatted
     * names.
     *
     * @throws Exception When an error occurs while fetching time zone information.
     *
     * @return array Returns an array containing information about all available time zones.
     * The array is sorted by offset in ascending order.
     * Each element of the array is an associative array with the following keys:
     * - 'timezone': The time zone identifier.
     * - 'name': The formatted name of the time zone, including the offset.
     * - 'offset': The offset of the time zone from UTC in seconds.
     * If the operation fails, an empty array is returned.
     *
     * @psalm-return array<array-key, array<string, mixed>>
     */
    public static function getAll(): array
    {
        $timeZones = [];
        $listsIdentifiers = DateTimeZone::listIdentifiers();

        foreach ($listsIdentifiers as $timeZone) {
            if (!empty($timeZone)) {
                $name = str_replace('_', ' ', $timeZone);
                $date = new DateTime('now', new DateTimeZone($timeZone));
                $timeZones[] =
                    [
                        'timezone' => $timeZone,
                        'name' => "$name (UTC {$date->format('P')})",
                        'offset' => $date->getOffset(),
                    ]
                ;
            }
        }

        $offsets = array_column($timeZones, 'offset');
        array_multisort($offsets, SORT_ASC, $timeZones);

        return $timeZones;
    }
}
