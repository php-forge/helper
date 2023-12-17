<?php

declare(strict_types=1);

namespace PHPForge\Helpers;

use DateTime;
use DateTimeZone;
use Exception;

use function array_column;
use function array_multisort;

final class TimeZone
{
    /**
     * @throws Exception
     *
     * @psalm-return array<array-key, array<array-key, mixed>|object>
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
