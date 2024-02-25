<?php

declare(strict_types=1);

namespace PHPForge\Helper\Tests;

use PHPForge\Helper\TimeZone;
use PHPUnit\Framework\TestCase;

final class TimeZoneTest extends TestCase
{
    public function testGetAll(): void
    {
        $timeZone = TimeZone::getAll();

        $this->assertIsArray($timeZone);
        $this->assertSame('Pacific/Midway', $timeZone[0]['timezone']);
        $this->assertSame('Pacific/Midway (UTC -11:00)', $timeZone[0]['name']);
        $this->assertSame(-39600, $timeZone[0]['offset']);
    }

    public function testGetAllCount(): void
    {
        $timeZone = TimeZone::getAll();

        $this->assertGreaterThan(400, count($timeZone));
    }

    public function testGellAllNotCharacter(): void
    {
        $timeZone = TimeZone::getAll();

        foreach ($timeZone as $value) {
            $this->assertStringNotContainsString('_', $value['name']);
        }
    }

    public function testGetAllReturnsOrderedTimeZones()
    {
        $timeZones = TimeZone::getAll();
        $prevOffset = null;

        foreach ($timeZones as $timeZone) {
            // verify that the offset is greater than or equal to the previous offset
            if ($prevOffset !== null) {
                $this->assertGreaterThanOrEqual($prevOffset, $timeZone['offset']);
            }

            // verify that the array contains the expected keys
            $this->assertArrayHasKey('timezone', $timeZone);
            $this->assertArrayHasKey('name', $timeZone);
            $this->assertArrayHasKey('offset', $timeZone);

            $prevOffset = $timeZone['offset'];
        }
    }
}
